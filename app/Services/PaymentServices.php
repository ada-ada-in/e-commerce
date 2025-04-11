<?php
namespace App\Services;
use Midtrans\Config;
use Config\Midtrans;
use App\Models\PaymentModel;
use App\Models\UserModel;
use App\Models\TransactionsModel;

class PaymentServices {
    protected $paymentModel;
    protected $transactionModel;
    protected $usermodel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->transactionModel = new TransactionsModel();
        $this->usermodel = new UserModel();
        Midtrans::init();
    }

    public function addPaymentServices(array $data){

    $rules = [
            'transactions_id'    => [
                'label' => 'transactions_id',
                'rules' => 'required'
            ],
            'payment_methode'       => [
                'label' => 'payment_methode',
                'rules' => 'required'
            ]
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if(!$validation->run($data)){
            return [
                'status' => false,
                'errors' => $validation->getErrors()
            ];
        }


        $transaction = $this->transactionModel->find($data['transactions_id']);
        if (!$transaction) {
            return [
                'status' => false,
                'errors' => ['transaction' => 'Transaction not found']
            ];
        }

        $user = $this->usermodel->find($transaction['user_id']);
        if (!$user) {
            return [
                'status' => false,
                'errors' => ['user' => 'Transaction not found']
            ];
        }

        $midtransParams = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $transaction['total_price']
            ],
            'customer_details' => [
                'first_name' => $user['name'],
                'email'      => $user['email'],
                'phone'      => $user['phone']
            ]
        ];

        try{

            $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);

            $this->paymentModel->insert([
                'order_id' => $midtransParams['transaction_details']['order_id'],
                'transactions_id' => $data['transactions_id'],
                'payment_methode' => $data['payment_methode'],
                'payment_status' => $data['payment_status'] || 'pending',
                'snap_token' => $snapToken
            ]);
    
            return [
                'status' => true,
                'message' => 'Payment created successfully',
                'snap_token' => $snapToken,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v2/vtweb/$snapToken",
                'order_id' => $midtransParams['transaction_details']['order_id']
            ];

        }catch(\Exception $e){
            return [
                'status' => false,
                'message' => 'Midtrans error: ' . $e->getMessage()
            ];
        }
     }

     

     public function deleteDataPaymentByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $paymentData = new PaymentModel();
    
        $data = $paymentData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
     }


     public function getPaymentDataServices()
     {
         
         $paymentData = new PaymentModel();
         $data = $paymentData->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'category is empty'
             ];
         }
 
         return $data;
     }

     public function getLatestPaymentServices(){
        $paymentData = new PaymentModel();
        $data = $paymentData
        ->orderBy('created_at', 'DESC')
        ->limit(6)                      
        ->findAll();     
        
        return $data;
    }


     public function getDataPaymentByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $paymentData = new PaymentModel();
    
        $data = $paymentData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function updateDataByPaymentIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $paymentData = new PaymentModel();
    
        $existingCategory = $paymentData->find($id);
        if (!$existingCategory) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        $updateData = [
            'transactions_id'    => $data['transactions_id'] ?? $existingCategory['transactions_id'],
            'payment_methode'       => $data['payment_methode'] ?? $existingCategory['payment_methode'],
            'payment_status'       => $data['payment_status'] ?? $existingCategory['payment_status'],
        ];

    
        $paymentData->update($id, $updateData);
    
        $updatePayment = $paymentData->find($id);
    
        return $updatePayment;
    }
     
}


?>