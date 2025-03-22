<?php
namespace App\Services;
use App\Models\TransactionsModel;



class TransactionServices {
    protected $transactionsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
    }

    public function addTransactionServices(array $data){

    $rules = [
            'user_id'    => [
                'label' => 'user_id',
                'rules' => 'required'
            ],
            'total_price'       => [
                'label' => 'total_price',
                'rules' => 'required'
            ],
            'status'    => [
                'label' => 'status',
                'rules' => 'required|in_list[pending,paid,canceled]'
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

        $this->transactionsModel->insert([
            'user_id'    => $data['user_id'],
            'total_price'       => $data['total_price'],
            'status'       => $data['status'],
        ]);


        return [
            'status' => true,
            'message' => 'add transactions success'
        ];

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
         $data = $transactionData->findAll();
 
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
     
}


?>