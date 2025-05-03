<?php
namespace App\Services;
use App\Models\TransactionsModel;
use App\Models\UserModel;
use App\Services\DeliveryServices;
use App\Models\CartItemsModel;
use App\Models\TransactionsItemsModel;
use Config\Midtrans;

class TransactionServices {
    protected $transactionsModel;
    protected $usermodel;
    protected $deliveryservice;
    protected $cartModel;
    protected $transactionItemModel;


    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
        $this->usermodel = new UserModel();
        $this->deliveryservice = new DeliveryServices();
        $this->cartModel = new CartItemsModel();
        $this->transactionItemModel = new TransactionsItemsModel();

        Midtrans::init();
    }

    public function addTransactionServices(array $data)
    {
        $rules = [
            'total_price' => [
                'label' => 'Total Price',
                'rules' => 'required|numeric'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'required'
            ],
            'cart_items_ids' => [
                'label' => 'Cart Items',
                'rules' => 'required'
            ]
        ];
    
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
    
        if (!$validation->run($data)) {
            log_message('error', 'Validation errors: ' . json_encode($validation->getErrors()));
    
            return [
                'status' => false,
                'errors' => $validation->getErrors()
            ];
        }

        
        $sessionUserId = session()->get('id');
    
        $user = $this->usermodel->find($sessionUserId);
        if (!$user) {
            return [
                'status' => false,
                'errors' => ['transaction' => 'User not found']
            ];
        }
    
        $orderId = 'order_' . uniqid();
    
        $snapParams = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $data['total_price'],
            ],
            'expiry' => [ 
                'start_time' => date("Y-m-d H:i:s O"),
                'unit' => 'hour',
                'duration' => 24
            ],
            'customer_details' => [
                'first_name' => $user['name'] ?? 'Customer',
                'email' => filter_var($user['email'], FILTER_VALIDATE_EMAIL) ? $user['email'] : 'no-reply@example.com',
                'phone' => preg_match('/^\+?\d{8,15}$/', $user['phone']) ? $user['phone'] : '0000000000'
            ]
        ];
    
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($snapParams);
    
            if (empty($snapToken)) {
                return [
                    'status' => false,
                    'errors' => ['transaction' => 'Failed to generate Midtrans snap token']
                ];
            }

            if(empty($data['status'])) {
                $data['status'] = 'pending';
            }


            // Insert ke tabel transaksi utama
            $this->transactionsModel->insert([
                'user_id' => $sessionUserId,
                'order_id' => $orderId,
                'total_price' => $data['total_price'],
                'expire_time' => $snapParams['expiry']['start_time'],
                'status' => $data['status'],
                'snap_token' => $snapToken
            ]);
    
            $transactions_id = $this->transactionsModel->getInsertID();
    
            $cartItemIds = $data['cart_items_ids'];
            $cartItems = $this->cartModel->whereIn('id', $cartItemIds)->findAll();
    
            if (count($cartItems) !== count($cartItemIds)) {
                return [
                    'status' => false,
                    'message' => 'Some cart items not found',
                    'errors' => ['cart' => 'Invalid cart item IDs']
                ];
            }
    
            // Pindahkan ke transaction_items
            foreach ($cartItems as $item) {
                $this->transactionItemModel->insert([
                    'transactions_id' => $transactions_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['total_price'],
                ]);
            }
    
            // Hapus dari cart
            $this->cartModel->whereIn('id', $cartItemIds)->delete();
    

            if(empty($data['status_delivery'])) {
                $data['status_delivery'] = 'order';
            }

            // Tambah data delivery
            $deliveryData = [
                'transactions_id' => $transactions_id,
                'status' => $data['status_delivery'],
                'address' => $data['address']
            ];
    
            $deliveryResult = $this->deliveryservice->addDeliveryServices($deliveryData);
    
            if (!$deliveryResult['status']) {
                return [
                    'status' => false,
                    'message' => 'Transaction created, but failed to create delivery',
                    'errors' => $deliveryResult['errors']
                ];
            }
    
            return [
                'status' => true,
                'message' => 'Payment created successfully',
                'snap_token' => $snapToken,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken",
                'order_id' => $orderId
            ];
    
        } catch (\Exception $e) {
            log_message('error', 'Midtrans error: ' . $e->getMessage());
    
            return [
                'status' => false,
                'message' => 'Midtrans error occurred',
                'errors' => ['exception' => $e->getMessage()]
            ];
        }
    }
    

    public function getLatestTransactionServices(){
        $transactionData = new TransactionsModel();
        $data = $transactionData
        ->orderBy('created_at', 'DESC')
        ->limit(6)                      
        ->findAll();     

        if(!$data || empty($data)){
            return [
                'status' => false,
                'errors' => ['exception' => 'cannot get latest data transactions']
            ];
        }
        
        return $data;
    }

    

     public function deleteDataTransactionsByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionData = new TransactionsModel();
    
        $data = $transactionData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'transaction not found'
            ];
        }
    
        return $data;
     }



     public function getDataTransactionServices()
     {
         
         $transactionData = new TransactionsModel();
         $data = $transactionData->orderBy('created_at', 'DESC')->select('transactions.*, users.name as transactions_name, users.email as transactions_email, users.phone as transactions_phone' )->join('users', 'users.id = transactions.user_id')->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'transaction is empty'
             ];
         }
 
         return $data;
     }


     public function getDataTransactionPaidServices()
     {
         
         $transactionData = new TransactionsModel();
         $data = $transactionData->select('transactions.*, users.name as transactions_name, users.email as transactions_email, users.phone as transactions_phone')->join('users', 'users.id = transactions.user_id')->orderBy('created_at', 'DESC')
         ->where('status', 'settlement')->findAll();

         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'transaction is empty'
             ];
         }
         return $data;
     }
     
     


     public function getDataTransactionPendingServices()
     {
         
         $transactionData = new TransactionsModel();
         $data = $transactionData->select('transactions.*, users.name as transactions_name, users.email as transactions_email, users.phone as transactions_phone')->join('users', 'users.id = transactions.user_id')->orderBy('created_at', 'DESC')
         ->where('status', 'pending')->findAll();

         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'transaction is empty'
             ];
         }
         return $data;
     }

     public function getDataTransactionCancelServices()
     {
         
         $transactionData = new TransactionsModel();
         $data = $transactionData->select('transactions.*, users.name as transactions_name, users.email as transactions_email, users.phone as transactions_phone')->join('users', 'users.id = transactions.user_id')->orderBy('created_at', 'DESC')
         ->where('status', 'cancel')->findAll();

         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'transaction is empty'
             ];
         }
         return $data;
     }



     public function getDataTransactionsByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionData = new TransactionsModel();
    
        $data = $transactionData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function updateDataTransactionsByIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $transactionData = new TransactionsModel();
    
        $existingCategory = $transactionData->find($id);
        if (!$existingCategory) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        $updateData = [
            'user_id'    => $data['user_id'] ?? $existingCategory['user_id'],
            'total_price'   => $data['total_price'] ?? $existingCategory['total_price'],
            'status'   => $data['status'] ?? $existingCategory['status'],
        ];

    
        $transactionData->update($id, $updateData);
    
        $updateTransaction = $transactionData->find($id);
    
        return $updateTransaction;
    }

    public function countTransactionsServices(){
        $transactionData = new TransactionsModel();
        $data = $transactionData->where('status', 'settlement')->countAllResults(false);
    
        if ($data == 0) {
            return [
                'status' => false,
                'message' => 'Data order is empty'
            ];
        }

        return $data;
    }

    public function countProfitServices(){
        $transactionData = new TransactionsModel();
        $data = $transactionData
            ->selectSum('total_price')
            ->where('status', 'settlement')
            ->first();
    
        $total = $data['total_price'] ?? 0;
    
        if ($total == 0) {
            return [
                'status' => false,
                'message' => 'No profit data available',
            ];
        }

        return $total;
    
    }

    public function chartMonthGraphServices()
    {
        $transactionData = new TransactionsModel();
        $currentYear = date('Y'); // tahun sekarang, misal 2025
    
        $results = $transactionData
            ->select("MONTH(created_at) as month, status, COUNT(*) as total")
            ->whereIn('status', ['settlement', 'pending', 'cancel'])
            ->where("YEAR(created_at)", $currentYear) // tambahkan filter tahun
            ->groupBy(['MONTH(created_at)', 'status'])
            ->orderBy('MONTH(created_at)', 'ASC')
            ->findAll();
    
        // Inisialisasi data bulan
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = [
                'month' => date('F', mktime(0, 0, 0, $i, 10)),
                'settlement' => 0,
                'pending' => 0,
                'cancel' => 0,
            ];
        }
    
        // Masukkan data hasil query ke array
        foreach ($results as $row) {
            $month = (int) $row['month'];
            $status = $row['status'];
            $monthlyData[$month][$status] = (int) $row['total'];
        }
    
        // Ubah ke format array numerik untuk frontend (misalnya chart.js)
        $chartData = array_values($monthlyData);
    
        return $chartData;
    }
    
    
     
}


?>