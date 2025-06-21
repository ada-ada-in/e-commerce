<?php
namespace App\Controllers\Api\V1\WebHook;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TransactionsModel;
use App\Models\ProductModel;
use App\Models\TransactionsItemsModel;

class WebHookController extends ResourceController
{
    public function index()
    {
        try {
            $json = $this->request->getJSON();

            if (!$json) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['error' => 'Invalid request']);
            }

            $orderId = $json->order_id ?? null;
            $transactionStatus = $json->transaction_status ?? null;

            if ($transactionStatus === 'expired') {
                $transactionStatus = 'cancel';
            }

            if (!$orderId || !$transactionStatus) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['error' => 'Missing parameters']);
            }

            $transactionModel = new TransactionsModel();
            $transaction = $transactionModel->where('order_id', $orderId)->first();

            if (!$transaction) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                    ->setJSON(['error' => 'Transaction not found']);
            }

            // Update status transaksi
            $dataUpdate = [
                'status' => $transactionStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $transactionModel->update($transaction['id'], $dataUpdate);

            // Jika berhasil pembayaran, kurangi stok produk
            if ($transactionStatus === 'settlement') {
                $transactionId = $transaction['id'];

                $itemModel = new TransactionsItemsModel();
                $productModel = new ProductModel();

                $items = $itemModel->where('transactions_id', $transactionId)->findAll();

                foreach ($items as $item) {
                    $productId = $item['product_id'];
                    $quantityPurchased = $item['quantity'];

                    $productModel->where('id', $productId)
                                 ->set('stock', "stock - $quantityPurchased", false)
                                 ->update();
                }
            } 

            if ($transactionStatus === 'settlement') {
                $transactionId = $transaction['id'];

                $itemModel = new TransactionsItemsModel();
                $productModel = new ProductModel();

                $items = $itemModel->where('transactions_id', $transactionId)->findAll();

                foreach ($items as $item) {
                    $productId = $item['product_id'];
                    $quantityPurchased = $item['quantity'];

                    $productModel->where('id', $productId)
                                 ->set('stock', "stock - $quantityPurchased", false)
                                 ->update();
                }
            }

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON(['message' => 'Webhook received and processed successfully']);

        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError($e->getMessage());
        }
    }
}
