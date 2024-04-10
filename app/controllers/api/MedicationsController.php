<?php
declare(strict_types=1);
namespace App\controllers\api;
use Phalcon\Http\Response;
use App\models\Medications;
use Phalcon\Mvc\Model\Criteria;
use App\controllers\ControllerBase;
use Phalcon\Paginator\Adapter\Model;
use App\controllers\api\RestController;
use App\services\MedicationService;

class MedicationsController extends RestController
{
 
    public function findAll(){
        $medicationService = new MedicationService();
        $medications = $medicationService->getAll();
        $this->response->setJsonContent(
            [
                'status' => 'OK',
                'data'   => $medications,
            ]
        );
       
      return $this->response;
    }

    public function findOne(int $id){
        $medicationService = new MedicationService();
        $medication = $medicationService->getOne($id);
       
        $this->response->setJsonContent(
            [
                'status' => 'OK',
                'data'   => $medication,
            ]
        );
       
      return $this->response;
    }

}
