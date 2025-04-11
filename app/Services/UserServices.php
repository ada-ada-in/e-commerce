<?php
namespace App\Services;
use App\Models\UserModel;

class UserServices {
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getUserDataServices()
    {
        
        $userData = new UserModel();
        $data = $userData->findAll();

        if(empty($data)){
            return [
                'status'  => true,
                'message' => 'data is empty'
            ];
        }

        return $data;
    }

    public function getDataUserByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $userData = new UserModel();
    
        $data = $userData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function deleteDataUserByIdServices($id){
   
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $userData = new UserModel();
    
        $data = $userData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;

    }

    public function updateDataByUserIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $userModel = new UserModel();
    
        $existingUser = $userModel->find($id);
        if (!$existingUser) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $data['password'] = $existingUser['password'];
        }
    
        $updateData = [
            'name'    => $data['name'] ?? $existingUser['name'],
            'email'   => $data['email'] ?? $existingUser['email'],
            'phone'   => $data['phone'] ?? $existingUser['phone'],
            'address' => $data['address'] ?? $existingUser['address'],
            'role'    => $data['role'] ?? $existingUser['role'],
            'password'=> $data['password'] ?? $existingUser['password'],
        ];

    
        $userModel->update($id, $updateData);
    
        $updatedUser = $userModel->find($id);
    
        return $updatedUser;
    }

    public function countUserServices(){
        $userData = new UserModel();

        $count = $userData->where('role', 'user')->countAllResults();

        return $count;
    
    }
    
}

?>