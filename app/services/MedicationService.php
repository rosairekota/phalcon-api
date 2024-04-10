<?php
namespace App\services;
use Phalcon\Di\DiInterface;
use App\models\Medications;

class MedicationService{
    public function getAll(): array  {
        $medications = Medications::find();
        return $medications;
    }
    public function getOne(int $id): Medications  {
        $medication = Medications::findFirst($id);
        return $medication;
    }
}