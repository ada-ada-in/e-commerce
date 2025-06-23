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
            ],
            'address'    => [
                'label' => 'status',
                'rules' => 'required'
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
            'address'    => $data['address'],
            ]);


        return [
            'status' => true,
            'message' => 'add delivery success'
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
         $data = $deliveryData
        ->select('delivery.*, transactions.status as transactions_status')
        ->orderBy('delivery.created_at', 'DESC')
        ->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'delivery is empty'
             ];
         }
 
         return $data;
     }

     public function getDeliverySendServices()
     {
         
         $deliveryData = new DeliveryModel();
         $data = $deliveryData->where('status', 'send')->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'delivery send is empty'
             ];
         }
 
         return $data;
     }

     public function getDeliveryOrderServices()
     {
         
         $deliveryData = new DeliveryModel();
         $data = $deliveryData
         ->select('delivery.*, transactions.status as transactions_status')
         ->join('transactions', 'transactions.id = delivery.transactions_id')
         ->where('transactions.status', 'settlement')
         ->orderBy('delivery.created_at', 'DESC')
         ->findAll();
   
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'delivery order is empty'
             ];
         }
 
         return $data;
     }


     public function getDeliveryCompleteServices()
     {
         
         $deliveryData = new DeliveryModel();
         $data = $deliveryData->where('status', 'complete')->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'delivery complete is empty'
             ];
         }
 
         return $data;
     }


     public function getDeliveryPickUpServices()
     {
         
         $deliveryData = new DeliveryModel();
         $data = $deliveryData->where('status', 'pickup')->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'delivery pickup is empty'
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


    public function getDataDeliveryByTransactionsIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $deliveryData = new DeliveryModel();
    
        $data = $deliveryData->where('transactions_id', $id)->first();
    
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


    public function sortDataOrderByDateServices($startDate, $endDate)
        {
            if (empty($startDate) || empty($endDate)) {
                return [
                    'status' => false,
                    'message' => 'Start date and end date are required',
                    'data' => []
                ];
            }

            $orderData = new DeliveryModel();
            $data = $orderData
                ->where('created_at >=', $startDate . ' 00:00:00')
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->orderBy('created_at', 'DESC')
                ->findAll();

            return [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data ?? []
            ];
        }

    public function sortDataSendByDateServices($startDate, $endDate)
        {
            if (empty($startDate) || empty($endDate)) {
                return [
                    'status' => false,
                    'message' => 'Start date and end date are required',
                    'data' => []
                ];
            }

            $sendData = new DeliveryModel();
            $data = $sendData
                ->where('created_at >=', $startDate . ' 00:00:00')
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->orderBy('created_at', 'DESC')
                ->where('status', 'send')
                ->findAll();

            return [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data ?? []
            ];
        }

        public function sortDataPickUpByDateServices($startDate, $endDate)
        {
            if (empty($startDate) || empty($endDate)) {
                return [
                    'status' => false,
                    'message' => 'Start date and end date are required',
                    'data' => []
                ];
            }

            $pickUp = new DeliveryModel();
            $data = $pickUp
                ->where('created_at >=', $startDate . ' 00:00:00')
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->orderBy('created_at', 'DESC')
                ->where('status', 'pickup')
                ->findAll();

            return [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data ?? []
            ];
        }

        public function sortDataCompleteByDateServices($startDate, $endDate)
        {
            if (empty($startDate) || empty($endDate)) {
                return [
                    'status' => false,
                    'message' => 'Start date and end date are required',
                    'data' => []
                ];
            }

            $completeData = new DeliveryModel();
            $data = $completeData
                ->where('created_at >=', $startDate . ' 00:00:00')
                ->where('created_at <=', $endDate . ' 23:59:59')
                ->orderBy('created_at', 'DESC')
                ->where('status', 'complete')
                ->findAll();

            return [
                'status' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data ?? []
            ];
        }

        public function exportPdfOrder($startDate, $endDate)
    {
        $orderData = new DeliveryModel();
        return $orderData->orderBy('created_at', 'DESC')
        ->where('created_at >=', $startDate . ' 00:00:00')
        ->where('created_at <=', $endDate . ' 23:59:59')
        ->findAll();
    } 
     
        public function exportPdfSend($startDate, $endDate)
    {
        $sendData = new DeliveryModel();
        return $sendData->orderBy('created_at', 'DESC')
        ->where('created_at >=', $startDate . ' 00:00:00')
        ->where('created_at <=', $endDate . ' 23:59:59')
        ->where('status', 'send')
        ->findAll();
    } 
     
        public function exportPdfPickup($startDate, $endDate)
    {
        $pickupData = new DeliveryModel();
        return $pickupData->orderBy('created_at', 'DESC')
        ->where('created_at >=', $startDate . ' 00:00:00')
        ->where('created_at <=', $endDate . ' 23:59:59')
        ->where('status', 'pickup')
        ->findAll();
    } 
     
        public function exportPdfComplete($startDate, $endDate)
    {
        $completeData = new DeliveryModel();
        return $completeData->orderBy('created_at', 'DESC')
        ->where('created_at >=', $startDate . ' 00:00:00')
        ->where('created_at <=', $endDate . ' 23:59:59')
        ->where('status', 'complete')
        ->findAll();
    } 
     
}


?>