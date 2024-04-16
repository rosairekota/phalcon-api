<?php
namespace App\services;
use App\models\Medications;
use MedicationProviders;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Model\ManagerInterface;

class MedicationService{
   
    public function getAll(): mixed  {
        //var_dump($this->managerInterface);
        $medications = MedicationProviders::find();
        $medicationRelated =[];
        foreach ($medications as $medication) {
            $medicationRelated[]= $medication->getRelated('medication');
            $medicationRelated[]= ['provider' => $medication->getRelated('provider')];
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