<?php
namespace App\Services;
use App\Models\TransactionsModel;
use App\Models\UserModel;
use Config\Midtrans;

class TransactionServices {
    protected $transactionsModel;
    protected $usermodel;


    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
        $this->usermodel = new UserModel();
        Midtrans::init();
    }

    public function addTransactionServices(array $data)
{
    $rules = [
        'user_id' => [
            'label' => 'User ID',
            'rules' => 'required'
        ],
        'total_price' => [
            'label' => 'Total Price',
            'rules' => 'required|numeric'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|in_list[pending,settlement,deny,cancel,expire,failure,refund,partial_refund,chargeback]'
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

    $user = $this->usermodel->find($data['user_id']);
    if (!$user) {
        return [
            'status' => false,
            'errors' => ['transaction' => 'User not found']
        ];
    }

    $orderId = 'order_' . uniqid();
    $data['total_price'];
    $snapParams = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $data['total_price'],
        ],
        'expiry' => [ 
            'start_time' => date("Y-m-d H:i:s O"),
            'unit' => 'minutes',
            'duration' => 15
        ],
        'customer_details' => [
            'first_name' => $user['name'] ?? 'Customer',
            'email' => filter_var($user['email'], FILTER_VALIDATE_EMAIL) ? $user['email'] : 'no-reply@example.com',
            'phone' => preg_match('/^\+?\d{8,15}$/', $user['phone']) ? $user['phone'] : '0000000000'
        ]
    ];

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($snapParams);

        if (empty($snapToken) || !$snapToken) {
            return [
                'status' => false,
                'errors' => ['transaction' => 'Failed to generate Midtrans snap token']
            ];
        }

        $this->transactionsModel->insert([
            'user_id' => $data['user_id'],
            'order_id' => $orderId,
            'total_price' => $data['total_price'],
            'expire_time' => $snapParams['expiry']['start_time'],
            'status' => $data['status'],
            'snap_token' => $snapToken
        ]);

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
         $data = $transactionData->orderBy('created_at', 'DESC')
         ->where('status', 'paid')
         
         ->findAll(); 
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