<?php
namespace App\Controllers\User;
use CodeIgniter\RESTful\ResourceController;
use App\Services\UserServices;

class UserController extends ResourceController {

    protected $registerServices;

    public function __construct()
    {
        $this->registerServices = new UserServices();
    }

    public function register()
    {
        try {
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }
    
            $result = $this->registerServices->registerUser($data);
    
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
    
}


?>