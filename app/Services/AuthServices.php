<?php
namespace App\Services;
use App\Models\UserModel;



class AuthServices {
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function registerServices(array $data){

    $rules = [
            'name'    => [
                'label' => 'name',
                'rules' => 'required|min_length[2]'
            ],
            'email'       => [
                'label' => 'email',
                'rules' => 'required|valid_email|is_unique[users.email]'
            ],
            'address' => [
                'label' => 'address',
                'rules' => 'required|min_length[3]'
            ],
            'phone'   => [
                'label' => 'phone',
                'rules' => 'required|min_length[12]'
            ],
            'role'   => [
                'label' => 'role',
                'rules' => 'permit_empty|min_length[2]'
            ],
            'password'    => [
                'label' => 'password',
                'rules' => 'required|min_length[6]'
            ],
            'confirm_password' => [
                'label' => 'confirm_password',
                'rules' => 'required|matches[password]'
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

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        if(empty($data['role'])){
            $data['role'] = 'user';
        }

        $this->userModel->insert([
            'name'    => $data['name'],
            'email'       => $data['email'],
            'phone'    => $data['phone'],
            'address' => $data['address'],
            'role'   => $data['role'],
            'password'   => $data['password'],
        ]);


        return [
            'status' => true,
            'message' => 'user register success'
        ];

     }


     public function loginServices(array $data){

        $email = $data['email'] ;
        $password = $data['password'];

        if(empty($email) || empty($password)){
            return [
                'status'  => false,
                'message' => 'Email or password cannot be empty'
            ];
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if(!$user){
            return [
                'status' => false,
                'message' => 'user not found'
            ];
        }

        if (password_verify($password, $user['password'])) {
            session()->set([
                'id' => $user['id'],
                'role' => $user['role'],
                'isLoggedIn' => true
            ]); 

            return [
                'status'  => true,
                'message' => 'Login successful'
            ];
            
        } else {
            return [
                'status' => false,
                'message' => 'email or password incorrect'
            ];
        } 


     }

     

}


?>