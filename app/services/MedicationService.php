<?php
namespace App\services;
use App\models\Medications;
use MedicationProviders;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Model\ManagerInterface;

class MedicationService{
   
    public function getAll(): mixed  {
        //var_dump($this->managerInterface);
        $medications = Medications::find();
        $medicationRelated =[];
        foreach ($medications as $medication) {
            $medicationData = [
                'id' => $medication->id,
                'name' => $medication->name,
                'providers' => $medication->getRelated('providers') 
            ];
            $medicationRelated[]=  $medicationData;
        }
        return $medicationRelated;
    }
    public function getOne(int $id) {
        $medication = Medications::findFirst($id);
        return [
            $medication,
            "providers"   =>  $medication->getRelated('providers')
        ] ;
    }
}