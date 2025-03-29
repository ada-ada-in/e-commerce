<?php
namespace App\Services;
use App\Models\PaymentModel;



class PaymentServices {
    protected $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
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
            ],
            'payment_status'       => [
                'label' => 'payment_status',
                'rules' => 'required|in_list[transfer,cod,onsite]'
            ],
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if(!$validation->run($data)){
            return [
                'status' => false,
                'errors' => $validation->getErrors()
            ];
        }

        $this->paymentModel->insert([
            'transactions_id'    => $data['transactions_id'],
            'payment_methode'       => $data['payment_methode'],
            'payment_status'       => $data['payment_status'],
        ]);


        return [
            'status' => true,
            'message' => 'add payment success'
        ];

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