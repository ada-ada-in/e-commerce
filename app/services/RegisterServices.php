<?php
namespace App\Services\RegisterServices;
use App\Models\UserModel;


class RegisterServices {
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function registerUser(array $data){
        $rules = [
            'username'    => [
                'label' => 'username',
                'rules' => 'required|min_length[3]'
            ],
            'email'       => [
                'label' => 'email',
                'rules' => 'required|valid_email'
            ],
            'password'    => [
                'label' => 'password',
                'rules' => 'required|min_lengt(6)'
            ],
            'namalengkap' => [
                'label' => 'namalengkap',
                'rules' => 'required|min_length(3)'
            ],
            'handphone'   => [
                'label' => 'handphone',
                'rules' => 'required|min_length(12)'
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

        $this->userModel->insert([
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => $data['password'],
            'namalengkap' => $data['namalengkap'],
            'handphone'   => $data['handphone'],
        ]);


        return [
            'status' => true,
            'message' => 'user register success'
        ];

     }
}


?>