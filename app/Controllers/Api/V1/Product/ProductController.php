<?php
namespace App\Controllers\Api\V1\Product;

use CodeIgniter\RESTful\ResourceController;
use App\Services\ProductServices;

class ProductController extends ResourceController {

    protected $productServices;

    public function __construct()
    {
        $this->productServices = new ProductServices();
    }


    public function addProduct()
    {
        try {
            $image = $this->request->getFile('image');
            $data = $this->request->getPost();

            
            if (!$image->isValid()) {
                return $this->fail([
                    'error' => 'Invalid file.',
                    'debug' => $image->getError()
                ], 400);
            }

            if (!file_exists($image->getTempName())) {
                return $this->fail([
                    'error' => 'Temporary file missing.',
                    'debug' => $image->getTempName()
                ], 400);
            }
            
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/', $imageName);

            $data['image_url'] = 'uploads/' . $imageName;            
            $result = $this->productServices->addProductServices($data);
            
            return $this->respondCreated([
                'message' => 'add product success',
                'file_name' => $imageName,
                'data' => $result
            ]);
     
        } catch (\Exception $e) {
            return $this->fail([
                'error' => 'An error occurred.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function deleteProduct($id){
        try {
    
            $deletedData = $this->productServices->deleteDataProductByIdServices($id);
    
            return $this->respondDeleted([
                'status'  => true,
                'data'    => $deletedData,
                'message' => 'Data deleted successfully'
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataProduct(){

        try {
            $data = $this->productServices->getProductDataServices();
    
            return $this->respond([
                'data' => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }

    
    public function getDataProductById($id){
        try {
    
            $data = $this->productServices->getDataProductByIdServices($id);
    
            return $this->respond([
                'status'  => true,
                'data'    => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateDataProductById($id)
    {
        try {
            $data = $this->request->getRawInput();
    
            $image = $this->request->getFile('image');
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $data['image'] = $image; 
            }
    
            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }
    
            $updatedData = $this->productServices->updateDataByProductIdServices($id, $data);
    
            if (!$updatedData) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'Failed to update product'
                ], 400);
            }
    
            return $this->respondUpdated([
                'status'  => true,
                'data'    => $updatedData,
                'message' => 'Data updated successfully'
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function countProduct(){
        try{

            $data = $this->productServices->countProductServices();

            return $this->respond([
                'status' => false,
                'data' => $data,
                'message' => 'Data retrieved successfully'
            ]);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'messge' => $e->getMessage()
            ], 500);
        }
    }
    
 
}


?>