<?php
namespace App\Controllers\Api\V1\Auth;

use CodeIgniter\RESTful\ResourceController;
use App\Services\AuthServices;

class AuthController extends ResourceController {

    
    protected $registerServices;

    public function __construct()
    {
        $this->registerServices = new AuthServices();
    }



    public function register(){
        try {
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }
    
            $result = $this->registerServices->registerServices($data);
    
            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }
    
            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message']
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }


    public function login() {
        try {
            
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }

            $result = $this->registerServices->loginServices($data);

            if ($result['status'] == false) {
                return $this->fail(
                    $result['message']
                );
            }
    
            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message']
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function logout() {
        session()->destroy();
        return $this->respond([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }
}
?>
