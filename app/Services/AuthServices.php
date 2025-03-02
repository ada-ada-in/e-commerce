<?php 
namespace App\Controllers\Service;
use App\Models\UserModel;

class AuthServices {
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login(array $data){
        
    }
}

?>