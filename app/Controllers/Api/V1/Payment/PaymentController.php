<?php
namespace App\Controllers\Api\V1\Payment;

use CodeIgniter\RESTful\ResourceController;
use App\Services\PaymentServices;

class PaymentController extends ResourceController {

    protected $PaymentServices;

    public function __construct()
    {
        $this->PaymentServices = new PaymentServices();
    }


    public function addPayment(){
        try {
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }
    
            $result = $this->PaymentServices->addPaymentServices($data);
    
            if ($result['status'] == false) {
                $errorData = isset($result['errors']) ? $result['errors'] : (isset($result['message']) ? $result['message'] : 'Unknown error');
                return $this->fail($errorData);
            }
    
            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message'],
                'snap_token' => $result['snap_token'],
                'redirect_url' => $result['redirect_url']
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }

    public function deletePayment($id){
        try {
    
            $deletedData = $this->PaymentServices->deleteDataPaymentByIdServices($id);
    
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

    public function getDataPayment(){

        try {
            $data = $this->PaymentServices->getPaymentDataServices();
    
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

    public function getLatestPayment(){
        try{

            $data = $this->PaymentServices->getLatestPaymentServices();

            return $this->respond([
                 'data' => $data,
                'message' => 'Data retrieved successfully'
            ],200);

        }catch(\Exception $e){
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    
    public function getDataPaymentById($id){
        try {
    
            $data = $this->PaymentServices->getDataPaymentByIdServices($id);
    
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

    public function updateDataTransactionyById($id)
    {
        try {
            $data = $this->request->getJSON(true);
    
            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }
    
            $updatedData = $this->PaymentServices->updateDataByPaymentIdServices($id, $data);
    
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
 
}


?>