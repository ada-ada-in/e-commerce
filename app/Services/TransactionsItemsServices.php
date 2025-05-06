<?php
namespace App\Services;
use App\Models\TransactionsItemsModel;
use App\Models\ProductModel;



class TransactionsItemsServices {
    protected $transationsItemsModel;
    protected $productModel;

    public function __construct()
    {
        $this->transationsItemsModel = new TransactionsItemsModel();
        $this->productModel = new ProductModel();
    }

    public function addTransactionsItemServices(array $data){

    $rules = [
            'transactions_id'    => [
                'label' => 'transactions_id',
                'rules' => 'required'
            ],
            'product_id'       => [
                'label' => 'product_id',
                'rules' => 'required'
            ],
            'quantity'    => [
                'label' => 'quantity',
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

        $product = $this->productModel->where('id', $data['product_id'])->first();
        
        if (!$product) {
            return [
                'status' => false,
                'errors' => ['product_id' => 'Product not found']
            ];
        }

        $this->transationsItemsModel->insert([
            'transactions_id'    => $data['transactions_id'],
            'product_id'       => $data['product_id'],
            'quantity'       => $data['quantity'],
            'price'           => $data['quantity'] * $product['price'],
        ]);


        return [
            'status' => true,
            'message' => 'add transactions items success'
        ];

     }

     public function deleteDataTransactionsItemsByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionsItemData = new TransactionsItemsModel();
    
        $data = $transactionsItemData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'transaction not found'
            ];
        }
    
        return $data;
     }


     public function getDataTransactionItemsServices()
     {
         
         $transactionsItemData = new TransactionsItemsModel();
         $data = $transactionsItemData->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'transaction is empty'
             ];
         }
 
         return $data;
     }

     public function getDataTransactionsItemsByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionsItemData = new TransactionsItemsModel();
    
        $data = $transactionsItemData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function getDataTransactionsItemsByTransactionsServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionsItemData = new TransactionsItemsModel();
    
        $data = $transactionsItemData->select('transactions_items.*, product.name as productitems_name,  product.price as items_price, product.image_url as item_image_url')->join('product', 'product.id = transactions_items.product_id')->where('transactions_id', $id)->orderBy('created_at', 'DESC')->findAll();
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'transactions not found'
            ];
        }
    
        return $data;
    }


    public function updateDataTransactionsItmesByIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $transactionsItemData = new TransactionsItemsModel();
    
        $existingCategory = $transactionsItemData->find($id);
        if (!$existingCategory) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }


        
        $product = $this->productModel->where('id', $data['product_id'])->first();
        
        if (!$product) {
            return [
                'status' => false,
                'errors' => ['product_id' => 'Product not found']
            ];
        }

    
        $updateData = [
            'transactions_id'    => $data['transactions_id'] ?? $existingCategory['transactions_id'],
            'product_id'   => $data['product_id'] ?? $existingCategory['product_id'],
            'quantity'   => $data['quantity'] ?? $existingCategory['quantity'],
            'price'   => $data['quantity'] * $product['price'] ?? $existingCategory['price'],
        ];

    
        $transactionsItemData->update($id, $updateData);
    
        $updateTransaction = $transactionsItemData->find($id);
    
        return $updateTransaction;
    }
     
}


?>