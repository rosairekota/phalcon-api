<?php
namespace App\models;

use MedicationProviders;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Providers;

class Medications extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("medication_db_phalcon");
        $this->setSource("medications");
        $this->hasManyToMany(
            'id',
            MedicationProviders::class,
            'provider_id',
            'medication_id',
            Providers::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'providers',
            ]
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Medications[]|Medications|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Medications|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
