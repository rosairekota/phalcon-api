<?php

use Phalcon\Mvc\Micro as Api;
use Phalcon\Mvc\Micro\Collection;
use App\controllers\api\MedicationsController;


$app = new Api($di);
$medicationApiRessources = (new Collection())
->setHandler(
    new MedicationsController(),
)->get(
    '/api/medications',
    'findAll',
)->get(
    '/api/medications/{id}',
    'findOne',
);
$app->mount($medicationApiRessources);
$app->handle($_SERVER["REQUEST_URI"]);