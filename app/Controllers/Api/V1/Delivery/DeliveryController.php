<?php
namespace App\Controllers\Api\V1\Delivery;
use CodeIgniter\RESTful\ResourceController;
use App\Services\DeliveryServices;
use App\Models\DeliveryModel;

class DeliveryController extends ResourceController {

    protected $deliveryServices;

    public function __construct()
    {
        $this->deliveryServices = new DeliveryServices();
    }



    public function addDelivery(){
        try {
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }
    
            $result = $this->deliveryServices->addDeliveryServices($data);
    
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


    public function deleteDelivery($id){
        try {
    
            $deletedData = $this->deliveryServices->deleteDataDeliveryByIdServices($id);
    
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



    public function getDataDelivery(){

        try {
            $data = $this->deliveryServices->getDeliveryDataServices();
    
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

    public function getDataSendDelivery(){

        try {
            $data = $this->deliveryServices->getDeliverySendServices();
    
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
    
    
    public function getDataOrderDelivery(){

        try {
            $data = $this->deliveryServices->getDeliveryOrderServices();
    
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

    
    public function getDataPickUpDelivery(){

        try {
            $data = $this->deliveryServices->getDeliveryPickUpServices();
    
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


    public function getDataCompleteDelivery(){

        try {
            $data = $this->deliveryServices->getDeliveryCompleteServices();
    
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


    public function getDataTrackingDelivery()
    {
        try {
            $request = service('request'); 
            $tracking_number = (string) $request->getVar('tracking_number'); 
    
            if (!$tracking_number) {
                return $this->fail([
                    'message' => 'Tracking number is required'
                ], 400);
            }
    
            $deliveryData = new DeliveryModel();
            $data = $deliveryData->where('tracking_number', $tracking_number)->first();

            if (!$data) {
                return $this->fail([
                    'message' => 'Tracking data not found'
                ], 404);
            }
    
            return $this->respond([
                'data' => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getDataDeliveryById($id){
        try {
    
            $data = $this->deliveryServices->getDataDeliveryByIdServices($id);
    
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

    
    public function updateDataCategoryById($id)
    {
        try {
            $data = $this->request->getJSON(true);
    
            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }
    
            $updatedData = $this->deliveryServices->updateDataByDeliveryIdServices($id, $data);
    
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