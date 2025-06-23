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

    public function getDataDeliveryByTransactionsId($id){
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
    

     public function sortOrderByDate(){
        try{
            $startDate = $this->request->getGet('start_date');
            $endDate = $this->request->getGet('end_date');

            if (!$startDate || !$endDate) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter start_date dan end_date wajib diisi.'
                ])->setStatusCode(400);
            }

            $data = $this->deliveryServices->sortDataOrderByDateServices($startDate, $endDate);

            if(!$data || empty($data)){
                return $this->fail([
                    'status' => false,
                    'message' => 'data empty'
                ]);
            }

            return $this->respond([
                'status' => true,
                'data' => $data,
                'message' => 'Data retrieved succesfully'
            ], 200);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

     public function sortSendByDate(){
        try{
            $startDate = $this->request->getGet('start_date');
            $endDate = $this->request->getGet('end_date');

            if (!$startDate || !$endDate) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter start_date dan end_date wajib diisi.'
                ])->setStatusCode(400);
            }

            $data = $this->deliveryServices->sortDataSendByDateServices($startDate, $endDate);

            if(!$data || empty($data)){
                return $this->fail([
                    'status' => false,
                    'message' => 'data empty'
                ]);
            }

            return $this->respond([
                'status' => true,
                'data' => $data,
                'message' => 'Data retrieved succesfully'
            ], 200);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

     public function sortPickUpByDate(){
        try{
            $startDate = $this->request->getGet('start_date');
            $endDate = $this->request->getGet('end_date');

            if (!$startDate || !$endDate) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter start_date dan end_date wajib diisi.'
                ])->setStatusCode(400);
            }

            $data = $this->deliveryServices->sortDataPickUpByDateServices($startDate, $endDate);

            if(!$data || empty($data)){
                return $this->fail([
                    'status' => false,
                    'message' => 'data empty'
                ]);
            }

            return $this->respond([
                'status' => true,
                'data' => $data,
                'message' => 'Data retrieved succesfully'
            ], 200);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

     public function sortCompleteByDate(){
        try{
            $startDate = $this->request->getGet('start_date');
            $endDate = $this->request->getGet('end_date');

            if (!$startDate || !$endDate) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Parameter start_date dan end_date wajib diisi.'
                ])->setStatusCode(400);
            }

            $data = $this->deliveryServices->sortDataCompleteByDateServices($startDate, $endDate);

            if(!$data || empty($data)){
                return $this->fail([
                    'status' => false,
                    'message' => 'data empty'
                ]);
            }

            return $this->respond([
                'status' => true,
                'data' => $data,
                'message' => 'Data retrieved succesfully'
            ], 200);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function printDataOrder()
    {
        try {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            if (!$startDate || !$endDate) {
                return $this->failValidationErrors('Start and End dates are required.');
            }

            $data = $this->deliveryServices->exportPdfOrder($startDate, $endDate);

            if (empty($data)) {
                return $this->failNotFound('No transactions found.');
            }

            $html = view('print/OrderPages', ['orders' => $data]);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Tambahkan header agar jelas bahwa ini PDF
            header('Content-Type: application/pdf');
            $dompdf->stream('orders.pdf', ['Attachment' => false]);
            exit;

        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    public function printDataSend()
    {
        try {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            if (!$startDate || !$endDate) {
                return $this->failValidationErrors('Start and End dates are required.');
            }

            $data = $this->deliveryServices->exportPdfSend($startDate, $endDate);

            if (empty($data)) {
                return $this->failNotFound('No transactions found.');
            }

            $html = view('print/SendPages', ['sends' => $data]);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Tambahkan header agar jelas bahwa ini PDF
            header('Content-Type: application/pdf');
            $dompdf->stream('send.pdf', ['Attachment' => false]);
            exit;

        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    public function printDataPickUp()
    {
        try {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            if (!$startDate || !$endDate) {
                return $this->failValidationErrors('Start and End dates are required.');
            }

            $data = $this->deliveryServices->exportPdfPickup($startDate, $endDate);

            if (empty($data)) {
                return $this->failNotFound('No transactions found.');
            }

            $html = view('print/PickUpPages', ['pickups' => $data]);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Tambahkan header agar jelas bahwa ini PDF
            header('Content-Type: application/pdf');
            $dompdf->stream('pickup.pdf', ['Attachment' => false]);
            exit;

        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    public function printDataComplete()
    {
        try {
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');

            if (!$startDate || !$endDate) {
                return $this->failValidationErrors('Start and End dates are required.');
            }

            $data = $this->deliveryServices->exportPdfComplete($startDate, $endDate);

            if (empty($data)) {
                return $this->failNotFound('No transactions found.');
            }

            $html = view('print/CompletePages', ['pickups' => $data]);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Tambahkan header agar jelas bahwa ini PDF
            header('Content-Type: application/pdf');
            $dompdf->stream('complete.pdf', ['Attachment' => false]);
            exit;

        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
}

?>