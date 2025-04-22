<?php
namespace App\Controllers\Api\V1\Transactions;

use CodeIgniter\RESTful\ResourceController;
use App\Services\TransactionServices;

class TransactionsController extends ResourceController {

    protected $transactionServices;

    public function __construct()
    {
        $this->transactionServices = new TransactionServices();
    }


    public function addTransaction(){
        try {
            $data = $this->request->getJSON(true);

    
            if (empty($data)) {
                return $this->fail([
                    'error' => 'No data received.', 'debug' => $this->request->getBody()
                ]);
            }
    
            $result = $this->transactionServices->addTransactionServices($data);
    
            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }
    
            return $this->respondCreated([
                'data' => $data,
                'message' => $result['message'],
                'snap_token' => $result['snap_token'],
                'redirect_url' => $result['redirect_url'],
                'order_id' => $result['order_id'],
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }

    public function deleteTransaction($id){
        try {
    
            $deletedData = $this->transactionServices->deleteDataTransactionsByIdServices($id);
    
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

    public function getDataTransaction(){

        try {
            $data = $this->transactionServices->getDataTransactionServices();
    
            return $this->respond([
                'data' => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataPaidTransaction(){

        try {
            $data = $this->transactionServices->getDataTransactionPaidServices();
    
            return $this->respond([
                'data' => $data,
                'message' => 'Data retrieved successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getDataTransactionById($id){
        try {
    
            $data = $this->transactionServices->getDataTransactionsByIdServices($id);
    
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
    
            $updatedData = $this->transactionServices->updateDataTransactionsByIdServices($id, $data);
    
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

    public function countTransaction(){

        try{
            $data = $this->transactionServices->countTransactionsServices();
            if(!$data || empty($data)){
                return $this->fail([
                    'status' => false,
                    'message' => 'data empty'
                ], 400);
            }

            return $this->respond([
                'status' => true,
                'data' => $data,
                'message' => 'Data retrieved succesfully'
            ],200);

        }catch(\Error $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function countProfit(){
        try{
            $data = $this->transactionServices->countProfitServices();

            if(!$data || empty($data)){
                return $this->fail([
                    'status' => false,
                    'message' => 'data empty'
                ]);
            }

            return $this->respond([
                'status' => true,
                'data' => 'Rp ' . number_format((float) $data, 0, ',', '.'),
                'message' => 'Data retrieved succesfully'
            ], 200);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function chartMonthGraph(){
        try{
            $data = $this->transactionServices->chartMonthGraphServices();

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
 
}

?>