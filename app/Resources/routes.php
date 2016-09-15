<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    $date = "2016-08-31";
    $fecha = new DateTime("2016-08-31");
    var_dump($fecha);
    $fecha->add(new DateInterval('P1D'));
    var_dump($fecha);
    return $app->version();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    include 'Auth/routes.php';
    include 'Empleados/routes.php';
    $api->group(['middleware' => 'api.auth'], function ($api) {
        include 'QuejasyReclamos/routes.php';
        include 'Novedades/routes.php';
    });
});