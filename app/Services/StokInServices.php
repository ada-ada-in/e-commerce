<?php
namespace App\Services;

use App\Models\StokInModel;
use App\Models\ProductModel;



class StokInServices {
    protected $stokInModel;
    protected $productModel;

    public function __construct()
    { 
        $this->stokInModel = new StokInModel();
        $this->productModel = new ProductModel();
    }

    public function addStokInServices(array $data) {
        $rules = [
            'product_id' => [
                'label' => 'Product ID',
                'rules' => 'required|integer'
            ],
            'quantity' => [
                'label' => 'Quantity',
                'rules' => 'required|integer'
            ]
        ];
    
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
    
        if (!$validation->run($data)) {
            return [
                'status' => false,
                'errors' => $validation->getErrors()
            ];
        }
    
        $product = $this->productModel->where('id', $data['product_id'])->first();
    
        if (!$product) {
            return [
                'status' => false,
                'message' => 'Product not found'
            ];
        }
    
        $newStock = $product['stock'] + $data['quantity'];
        $this->productModel->update($data['product_id'], ['stock' => $newStock]);

        $this->stokInModel->insert([
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            ]);
    
        return [
            'status' => true,
            'message' => 'Stock updated successfully'
        ];
    }
    

     public function deleteDataStokInByIdServices($id)
     {
         if (!$id) {
             return [
                 'status'  => false,
                 'message' => 'ID is required'
             ];
         }
     
         $stokInModel = new StokInModel();
     
         $stokInData = $stokInModel->where('id', $id)->first();
     
         if (!$stokInData) {
             return [
                 'status'  => false,
                 'message' => 'stok id not found'
             ];
         }

         $product = $this->productModel->where('id', $stokInData['product_id'])->first();

         

         $newStock = $product['stock'] - $stokInData['quantity'];
         $this->productModel->update($stokInData['product_id'], ['stock' => $newStock]);
     

         $deleted = $stokInModel->where('id', $id)->delete();
     
         if (!$deleted) {
             return [
                 'status'  => false,
                 'message' => 'Failed to delete stok'
             ];
         }
     
         return [
             'status'  => true,
             'message' => 'stok deleted successfully'
         ];
     }
     


     public function getStokInDataServices()
     {
         
         $stokInData = new StokInModel();
         $data = $stokInData
         ->select('stok_in.*, product.name as product_name' )
        ->join('product', 'stok_in.product_id = product.id')
         ->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'product is empty'
             ];
         }
 
         return $data;
     }

     public function getDataStokInByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $stokInData = new StokInModel();
    
        $data = $stokInData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'stok not found'
            ];
        }
    
        return $data;
    }

    public function updateDataStokInByIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $stokInModel = new StokInModel();
    
        $stokInData = $stokInModel->find($id);
    
        if (!$stokInData) {
            return [
                'status'  => false,
                'message' => 'stok not found'
            ];
        }

        $product = $this->productModel->where('id', $data['product_id'])->first();

        if (!$product) {
            return [
                'status' => false,
                'message' => 'Product not found'
            ];
        }

        $newStock = $product['stock'] - $stokInData['quantity'] + $data['quantity'];
        $this->productModel->update($data['product_id'], ['stock' => $newStock]);

        $stokInModel->update($id, [
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
        ]);
    
        return [
            'status'  => true,
            'message' => 'stok updated successfully'
        ];
    }

    
     
}


?>