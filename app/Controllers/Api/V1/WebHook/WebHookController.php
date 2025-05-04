<?php
namespace App\Controllers\Api\V1\WebHook;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TransactionsModel;

class WebHookController extends ResourceController {


    public function index()
    {

        try {
            $json = $this->request->getJSON();

            if (!$json) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['error' => 'Invalid request']);
            }
    
            $orderId = $json->order_id ?? null;
            $transactionStatus = $json->transaction_status ?? null;

            if ($transactionStatus === 'expire') {
                $transactionStatus = 'cancel';
            }
                
            if (!$orderId || !$transactionStatus) {
                return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['error' => 'Missing parameters']);
            }
    
            $dataUpdate = [
                'status' => $transactionStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            // Update status transaksi di database kamu
            $transactionModel = new TransactionsModel();
    
            $transactionModel->where('order_id', $orderId)
                             ->set($dataUpdate)
                             ->update();
    
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON(['message' => 'Webhook received successfully']);
      
        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }

    }
}
   

?>