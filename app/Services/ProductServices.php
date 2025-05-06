<?php
namespace App\Services;
use App\Models\ProductModel;
use App\Models\CategoryModel;



class ProductServices {
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    { 
        $this->productModel = new ProductModel();
    }

    public function addProductServices(array $data){

    $rules = [
            'category_id'    => [
                'label' => 'category_id',
                'rules' => 'required'
            ],
            'name'       => [
                'label' => 'name',
                'rules' => 'required'
            ],
            'description'       => [
                'label' => 'description',
                'rules' => 'required'
            ],
            'price'       => [
                'label' => 'price',
                'rules' => 'required'
            ],
            'stock'       => [
                'label' => 'stock',
                'rules' => 'required'
            ],
            'image_url' => [
                'label' => 'image_url',
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

        if($data['category_id'] == 'undifiend' || empty($data['category_id'])){
            return [
                'status' => false,
                'errors' => ['product' => 'category empty or not found']
            ];        }

        $this->productModel->insert([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image_url'   => $data['image_url'],
            ]);
    
        return;
     }

     public function deleteDataProductByIdServices($id)
     {
         if (!$id) {
             return [
                 'status'  => false,
                 'message' => 'ID is required'
             ];
         }
     
         $productModel = new ProductModel();
     
         $product = $productModel->where('id', $id)->first();
     
         if (!$product) {
             return [
                 'status'  => false,
                 'message' => 'Product not found'
             ];
         }
     
         $imagePath = FCPATH . $product['image_url']; 
         if (file_exists($imagePath) && is_file($imagePath)) {
             unlink($imagePath);
         }
     
         $deleted = $productModel->where('id', $id)->delete();
     
         if (!$deleted) {
             return [
                 'status'  => false,
                 'message' => 'Failed to delete product'
             ];
         }
     
         return [
             'status'  => true,
             'message' => 'Product and image deleted successfully'
         ];
     }
     


     public function getProductDataServices()
     {
         
         $productData = new ProductModel();


         $data = $productData->orderBy('created_at', 'DESC')->getProductsWithCategory();
         
 
         if(empty($data)){
             return [       
                 'status'  => true,
                 'message' => 'product is empty'
             ];
         }

         foreach ($data as &$item) {
            if (isset($item['price'])) {
                $item['price'] = 'Rp ' . number_format($item['price'], 0, ',', '.');
            }
        }
         
 
         return $data;
     }


     public function getProductDataServicesByCategoryId($id)
     {
         
         $productData = new ProductModel();


         $data = $productData->where('category_id', $id)->orderBy('created_at', 'DESC')->getProductsWithCategory();
         
 
         if(empty($data)){
             return [       
                 'status'  => true,
                 'message' => 'product is empty'
             ];
         }
 
         return $data;
     }

     public function getDataProductByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $productData = new ProductModel();
    
        $data = $productData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function updateDataByProductIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $productData = new ProductModel();

        $existingProduct = $productData->find($id);
        if (!$existingProduct) {
            return [
                'status'  => false,
                'message' => 'Product not found'
            ];
        }

        $updateData = [
            'category_id'  => $data['category_id'] ?? $existingProduct['category_id'],
            'name'         => $data['name'] ?? $existingProduct['name'],
            'description'  => $data['description'] ?? $existingProduct['description'],
            'price'        => $data['price'] ?? $existingProduct['price'],
            'stock'        => $data['stock'] ?? $existingProduct['stock'],
        ];

        if (!empty($data['image_url'])) {
            $updateData['image_url'] = $data['image_url'];
        }

        if ($updateData == $existingProduct) {
            return [
                'status'  => false,
                'message' => 'No changes detected, update skipped'
            ];
        }

        $result = $productData->update($id, $updateData);

        if (!$result) {
            return [
                'status'  => false,
                'message' => 'Failed to update product',
                'debug_query' => $productData->db->getLastQuery()->getQuery()
            ];
        }

        $updatedProduct = $productData->find($id);

        return [
            'status'  => true,
            'message' => 'Product updated successfully',
            'data'    => $updatedProduct
        ];
    }

    public function countProductServices() {
        $countData = new ProductModel();
        
        $data = $countData->countAllResults();

        return $data;

    }

    
     
}


?>