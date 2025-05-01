<?php
namespace App\Services;
use App\Models\CartItemsModel;
use App\Models\ProductModel;



class CartItemServices {
    protected $cartItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartItemModel = new CartItemsModel();
        $this->productModel = new ProductModel();
    }

    public function addCartItemServices(array $data){

    $rules = [
            'product_id'    => [
                'label' => 'product_id',
                'rules' => 'required'
            ], 
            'user_id'       => [
                'label' => 'user_id',
                'rules' => 'required'
            ],
            'quantity'       => [
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

        $this->cartItemModel->insert([
            'product_id'    => $data['product_id'],
            'user_id'       => $data['user_id'],
            'quantity'       => $data['quantity'],
            'total_price'       => $data['quantity'] * $product['price'],
        ]);


        return [
            'status' => true,
            'message' => 'add cart items success'
        ];

     }

     public function deleteDataCartItemByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $cartItemData = new CartItemsModel();
    
        $data = $cartItemData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
     }


     public function getCartItemDataServices()
     {
         
         $cartItemData = new CartItemsModel();
         $data = $cartItemData->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'cart item is empty'
             ];
         }
 
         return $data;
     }

     public function getDataCartItemByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $cartItemData = new CartItemsModel();
    
        $data = $cartItemData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function getDataCartItemByUserServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $cartItemData = new CartItemsModel();
    
        $data = $cartItemData->where('user_id', $id)->findAll();
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function updateDataByCartItemIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $cartItemModel = new CartItemsModel();
    
        $existingCategory = $cartItemModel->find($id);
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
            'product_id'    => $data['product_id'] ?? $existingCategory['product_id'],
            'user_id'       => $data['user_id'] ?? $existingCategory['user_id'],
            'quantity'       => $data['quantity'] ?? $existingCategory['quantity'],
            'total_price'       => $data['quantity'] * $product['price'] ?? $existingCategory['total_price'],
        ];

    
        $cartItemModel->update($id, $updateData);
    
        $updateCartItem = $cartItemModel->find($id);
    
        return $updateCartItem;
    }
     
}


?>