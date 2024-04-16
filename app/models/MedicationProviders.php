<?php

use App\models\Medications;

class MedicationProviders extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $medication_id;

    /**
     *
     * @var integer
     */
    public $provider_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("medication_db_phalcon");
        $this->setSource("medication_providers");
        $this->belongsTo(
            'medication_id',
            Medications::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'medication'
            ]
        );

        $this->belongsTo(
            'provider_id',
            Providers::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'provider'
            ]
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MedicationProviders[]|MedicationProviders|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MedicationProviders|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
