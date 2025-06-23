<?php
namespace App\Controllers\Api\V1\Category;
use CodeIgniter\RESTful\ResourceController;
use App\Services\CategoryServices;
use Dompdf\Dompdf;

class CategoryController extends ResourceController {

    protected $categoryservices;

    public function __construct()
    {
        $this->categoryservices = new CategoryServices();
    }


    public function addCategory(){
        try {
            $image = $this->request->getFile('image');
            $data = $this->request->getPost();

            if (!$image->isValid()) {
                return $this->fail([
                    'error' => 'Invalid file.',
                    'debug' => $image->getError()
                ], 400);
            }

            if (!file_exists($image->getTempName())) {
                return $this->fail([
                    'error' => 'Temporary file missing.',
                    'debug' => $image->getTempName()
                ], 400);
            }
            

            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'category/', $imageName);

            $data['image_url'] = 'category/' . $imageName;            
    
            $result = $this->categoryservices->addCategoryServices($data);
    
            if ($result['status'] == false) {
                return $this->fail(
                    $result['errors']
                );
            }
    
            return $this->respondCreated([
                'data' => $data,
                'file_name' => $imageName,
                'message' => $result['message']
            ]);
    
        } catch (\Exception $e) {
            return $this->fail([
                 $e->getMessage()
            ]);
        }
    }

    public function deleteCategory($id){
        try {
    
            $deletedData = $this->categoryservices->deleteDataCategoryByIdServices($id);
    
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

    public function getDataCategory(){

        try {
            $data = $this->categoryservices->getCategoryDataServices();
    
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

    
    public function getDataCategoryById($id){
        try {
    
            $data = $this->categoryservices->getDataCategoryByIdServices($id);
    
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
            $data = $this->request->getPost();
            $image = $this->request->getFile('image');

            if ($image && $image->isValid() && !$image->hasMoved()) {
                if (!file_exists($image->getTempName())) {
                    return $this->fail([
                        'error' => 'Temporary file missing.',
                        'debug' => $image->getTempName()
                    ], 400);
                }

                $imageName = $image->getRandomName();
                $image->move(FCPATH . 'uploads/', $imageName);

                $data['image_url'] = 'uploads/' . $imageName;
            }

            if (!$data || empty($data)) {
                return $this->fail([
                    'status'  => false,
                    'message' => 'No data provided for update'
                ], 400);
            }
    
            $updatedData = $this->categoryservices->updateDataByCategoryIdServices($id, $data);
    
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


      public function printDataProduct()
    {
        try {
            $data = $this->categoryservices->exportPdfCategory();

            if (empty($data)) {
                return $this->failNotFound('No user data found');
            }

            $html = view('print/CategoryPages', ['categories' => $data]);

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('data_categories.pdf', ['Attachment' => false]);
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