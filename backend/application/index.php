<?php
// Skicka lite headers först
header('Content-Type: text/json; charset=utf-8');

require '../config/config.php';
require 'vendor/autoload.php';

$app = new \Slim\Slim($config['slim']);
$db = new medoo($config['medoo']);

include_once 'endpoints/auth.php';
include_once 'endpoints/building.php';
include_once 'endpoints/card.php';
include_once 'endpoints/category.php';
include_once 'endpoints/customer.php';
include_once 'endpoints/door.php';
include_once 'endpoints/facility.php';
include_once 'endpoints/partition.php';
include_once 'endpoints/reservation.php';
include_once 'endpoints/role.php';
include_once 'endpoints/server.php';
include_once 'endpoints/site.php';
include_once 'endpoints/user.php';

$app->run();
?>