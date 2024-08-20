<?php
use Libraries\Asteril\Asteril;
use Repositories\AsterilRepository\AsterilRepository;

require_once ('./Libraries/Curl/CurlRequest.php');
require_once ('./Libraries/Asteril/Asteril.php');
require_once ('./Repositories/BaseApiRepository.php');
require_once ('./Repositories/AsterilRepository.php');
require_once('./db/db.php');

const ASTERIL_API_ID = 1;
const ASTERIL_ORDERS_TYPE = 'Asteril/Orders';

$db = new Db();

$asterilRepository = new AsterilRepository($db);

try {
    $apiSettings = $asterilRepository->setApiId(ASTERIL_API_ID)->getSettings();
    $asteril = new Asteril($apiSettings);

    $apiParams = $asterilRepository->getParams(ASTERIL_ORDERS_TYPE);
    $ordersForChange = [];

    foreach ($apiParams as $params) {
        $changeCriteria = $asterilRepository->getChangeCriteria($params['id']);

        $i = 1;
        do {
            $res = $asteril->getOrders(json_decode($params['params'], true), $i);
            $res = json_decode($res, true);
            $pages = $res['pages'];
            $orders = $res['orders'];

            $ordersForChange = array_merge($ordersForChange, $asteril->compareOrdersAndCriteria($orders, $changeCriteria));

            $i++;
        } while ($pages >= $i);
    }

    $asteril->updateOrders($ordersForChange);
}catch (Exception $exception){
    //log
}







