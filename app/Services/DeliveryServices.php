<?php
namespace App\Services;
use App\Models\DeliveryModel;



class DeliveryServices {
    protected $deliveryModel;

    public function __construct()
    {
        $this->deliveryModel = new DeliveryModel();
    }

    public function addDeliveryServices(array $data){

    $rules = [
            'status'    => [
                'label' => 'status',
                'rules' => 'required|in_list[order,pickup,send]'
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

        do {
            $trackingNumber = random_int(10000000, 99999999); 
        } while ($this->deliveryModel->where('tracking_number', $trackingNumber)->countAllResults() > 0);

        $this->deliveryModel->insert([
            'transactions_id'    => $data['transactions_id'],
            'tracking_number'    => $trackingNumber,
            'status'    => $data['status'],
            ]);


        return [
            'status' => true,
            'message' => 'add payment success'
        ];

     }

     public function deleteDataDeliveryByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $deliveryData = new DeliveryModel();
    
        $data = $deliveryData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
     }


     public function getDeliveryDataServices()
     {
         
         $deliveryData = new DeliveryModel();
         $data = $deliveryData->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'delivery is empty'
             ];
         }
 
         return $data;
     }

     public function getDataDeliveryByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $deliveryData = new DeliveryModel();
    
        $data = $deliveryData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Delivery not found'
            ];
        }
    
        return $data;
    }

    public function getDataTrackingDeliveryByIdServices()
    {
        $request = service('request'); 
        $tracking_number = $request->getVar('tracking_number'); 
    
        if (!$tracking_number) {
            return [
                'status'  => false,
                'message' => 'Tracking number is required'
            ];
        }
    
        $deliveryData = new DeliveryModel();
        $data = $deliveryData->where('tracking_number', $tracking_number)->first();
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'Tracking not found'
            ];
        }
    
        return [
            'status' => true,
            'data' => $data
        ];
    }
    

    public function updateDataByDeliveryIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $deliveryModel = new DeliveryModel();
    
        $existingCategory = $deliveryModel->find($id);
        if (!$existingCategory) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        $updateData = [
            'transactions_id'    => $data['transactions_id'] ?? $existingCategory['transactions_id'],
            'tracking_number'   => $data['tracking_number'] ?? $existingCategory['tracking_number'],
            'status'   => $data['status'] ?? $existingCategory['status'],
        ];

    
        $deliveryModel->update($id, $updateData);
    
        $updateDelivery = $deliveryModel->find($id);
    
        return $updateDelivery;
    }
     
}


?>