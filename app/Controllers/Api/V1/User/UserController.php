<?php
namespace App\Controllers\Api\v1\User;
use App\Services\UserServices;
use CodeIgniter\RESTful\ResourceController;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class UserController extends ResourceController {
    protected $userServices;

    public function __construct() {
        $this->userServices = new UserServices();
    }

    public function getDataUser(){

        try {
            $data = $this->userServices->getUserDataServices();
    
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

    public function getDataUserProfile(){

        try {
            $data = $this->userServices->getUserProfileDataServices();
    
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
    

    public function getDataUserById($id){
        try {
    
            $data = $this->userServices->getDataUserByIdServices($id);
    
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

    public function getDataUserProfileById($id){
        try {
    
            $data = $this->userServices->getDataUserProfileByIdServices($id);
    
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

    public function deleteDataUserById($id){

        try {
    
            $deletedData = $this->userServices->deleteDataUserByIdServices($id);

            session()->setFlashdata('success', 'User berhasil dihapus!');
    
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
    
    public function updateDataUserById($id)
    {
        try {
            $data = $this->request->getJSON(true);
    
            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }

        
    
            $updatedData = $this->userServices->updateDataByUserIdServices($id, $data);

            session()->setFlashdata('success', 'User berhasil diupdate!');
    
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

    public function countUser(){
        try{
            $countData = $this->userServices->countUserServices();

            return $this->respondCreated([
                'status' => true,
                'data' => $countData,
                'message' => 'Data retrieved succesfully'
            ]);

        }catch(\Exception $e){
            return $this->fail([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

        public function printDataUser()
    {
        try {
            $data = $this->userServices->exportPdfUsers();

            if (empty($data)) {
                return $this->failNotFound('No user data found');
            }

            $html = view('print/UserPages', ['users' => $data]);

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('data_users.pdf', ['Attachment' => false]);
            exit;

        } catch (\Exception $e) {
            return $this->fail([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // public function exportExcelUser()
    // {
    //     try {
    //         $data = $this->userServices->exportExcelUsers();

    //         if (empty($data)) {
    //             return $this->failNotFound('No user data found');
    //         }

    //         $spreadsheet = new Spreadsheet();
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $sheet->setTitle('Data Users');

    //         // Set header
    //         $sheet->setCellValue('A1', 'No');
    //         $sheet->setCellValue('B1', 'Name');
    //         $sheet->setCellValue('C1', 'Email');
    //         $sheet->setCellValue('D1', 'Address');

    //         // Fill data
    //         foreach ($data as $i => $user) {
    //             $sheet->setCellValue('A' . ($i + 2), $i + 1);
    //             $sheet->setCellValue('B' . ($i + 2), $user['name']);
    //             $sheet->setCellValue('C' . ($i + 2), $user['email']);
    //             $sheet->setCellValue('D' . ($i + 2), $user['address']);
    //         }

    //         // Save to file
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment; filename="data_users.xlsx"');
    //         header('Cache-Control: max-age=0');
    //         $writer->save('php://output');
    //         exit;

    //     } catch (\Exception $e) {
    //         return $this->fail([
    //             'status'  => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
}
?>