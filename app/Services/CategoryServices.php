<?php
namespace App\Services;
use App\Models\CategoryModel;



class CategoryServices {
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function addCategoryServices(array $data){

    $rules = [
            'name'    => [
                'label' => 'name',
                'rules' => 'required|min_length[2]'
            ],
            'description'       => [
                'label' => 'description',
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

        $this->categoryModel->insert([
            'name'    => $data['name'],
            'description'       => $data['description'],
        ]);


        return [
            'status' => true,
            'message' => 'add category success'
        ];

     }

     public function deleteDataCategoryByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $userData = new CategoryModel();
    
        $data = $userData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
     }


     public function getCategoryDataServices()
     {
         
         $categoryData = new CategoryModel();
         $data = $categoryData->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'category is empty'
             ];
         }
 
         return $data;
     }

     public function getDataCategoryByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $categoryData = new CategoryModel();
    
        $data = $categoryData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function updateDataByCategoryIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $categoryModel = new CategoryModel();
    
        $existingCategory = $categoryModel->find($id);
        if (!$existingCategory) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        $updateData = [
            'name'    => $data['name'] ?? $existingCategory['name'],
            'description'   => $data['description'] ?? $existingCategory['description'],
        ];

    
        $categoryModel->update($id, $updateData);
    
        $updateCategory = $categoryModel->find($id);
    
        return $updateCategory;
    }
     
}


?>