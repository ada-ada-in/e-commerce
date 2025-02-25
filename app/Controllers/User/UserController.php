<?php
namespace App\Auth\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Services\RegisterServices\RegisterServices;

class UserController extends ResourceController {

    protected $registerServices;

    public function __construct()
    {
        $this->registerServices = new RegisterServices();
    }

    public function register()
    {
        $data = $this->request->getPost();
        $result = $this->registerServices->registerUser($data);

        if (!$result['status']) {
            return $this->fail($result['errors']);
        }

        return $this->respondCreated(['message' => $result['message']]);
    }

}


?>