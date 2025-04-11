<?php
namespace App\Services;
use App\Models\TransactionsModel;
use PDO;

class TransactionServices {
    protected $transactionsModel;

    public function __construct()
    {
        $this->transactionsModel = new TransactionsModel();
    }

    public function addTransactionServices(array $data){

    $rules = [
            'user_id'    => [
                'label' => 'user_id',
                'rules' => 'required'
            ],
            'total_price'       => [
                'label' => 'total_price',
                'rules' => 'required'
            ],
            'status'    => [
                'label' => 'status',
                'rules' => 'required|in_list[pending,paid,canceled]'
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

        $this->transactionsModel->insert([
            'user_id'    => $data['user_id'],
            'total_price'       => $data['total_price'],
            'status'       => $data['status'],
        ]);


        return [
            'status' => true,
            'message' => 'add transactions success'
        ];

     }

     public function deleteDataTransactionsByIdServices($id){
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionData = new TransactionsModel();
    
        $data = $transactionData->delete($id);

        if (!$data) {
            return [
                'status'  => false,
                'message' => 'transaction not found'
            ];
        }
    
        return $data;
     }


     public function getDataTransactionServices()
     {
         
         $transactionData = new TransactionsModel();
         $data = $transactionData->orderBy('created_at', 'DESC')->findAll();
 
         if(empty($data)){
             return [
                 'status'  => true,
                 'message' => 'transaction is empty'
             ];
         }
 
         return $data;
     }
     public function getDataTransactionsByIdServices($id){

        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }

        $transactionData = new TransactionsModel();
    
        $data = $transactionData->find($id);
    
        if (!$data) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        return $data;
    }

    public function updateDataTransactionsByIdServices($id, array $data)
    {
        if (!$id) {
            return [
                'status'  => false,
                'message' => 'ID is required'
            ];
        }
    
        $transactionData = new TransactionsModel();
    
        $existingCategory = $transactionData->find($id);
        if (!$existingCategory) {
            return [
                'status'  => false,
                'message' => 'User not found'
            ];
        }
    
        $updateData = [
            'user_id'    => $data['user_id'] ?? $existingCategory['user_id'],
            'total_price'   => $data['total_price'] ?? $existingCategory['total_price'],
            'status'   => $data['status'] ?? $existingCategory['status'],
        ];

    
        $transactionData->update($id, $updateData);
    
        $updateTransaction = $transactionData->find($id);
    
        return $updateTransaction;
    }

    public function countTransactionsServices(){
        $transactionData = new TransactionsModel();
        $data = $transactionData->where('status', 'paid')->countAllResults(false);
    
        if ($data == 0) {
            return [
                'status' => false,
                'message' => 'Data order is empty'
            ];
        }

        return $data;
    }

    public function countProfitServices(){
        $transactionData = new TransactionsModel();
        $data = $transactionData
            ->selectSum('total_price')
            ->where('status', 'paid')
            ->first();
    
        $total = $data['total_price'] ?? 0;
    
        if ($total == 0) {
            return [
                'status' => false,
                'message' => 'No profit data available',
            ];
        }

        return $total;
    
    }

    public function chartMonthGraphServices()
    {
        $transactionData = new TransactionsModel();
        $currentYear = date('Y'); // tahun sekarang, misal 2025
    
        $results = $transactionData
            ->select("MONTH(created_at) as month, status, COUNT(*) as total")
            ->whereIn('status', ['paid', 'pending', 'canceled'])
            ->where("YEAR(created_at)", $currentYear) // tambahkan filter tahun
            ->groupBy(['MONTH(created_at)', 'status'])
            ->orderBy('MONTH(created_at)', 'ASC')
            ->findAll();
    
        // Inisialisasi data bulan
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = [
                'month' => date('F', mktime(0, 0, 0, $i, 10)),
                'paid' => 0,
                'pending' => 0,
                'canceled' => 0,
            ];
        }
    
        // Masukkan data hasil query ke array
        foreach ($results as $row) {
            $month = (int) $row['month'];
            $status = $row['status'];
            $monthlyData[$month][$status] = (int) $row['total'];
        }
    
        // Ubah ke format array numerik untuk frontend (misalnya chart.js)
        $chartData = array_values($monthlyData);
    
        return $chartData;
    }
    
    
     
}


?>