<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['prefix' => 'empleados/{cedula}/jornadas_laborales', 'namespace' => 'App\Resources\JornadasLaborales\Controllers'],
    function () use ($api) {
        $api->get('/', 'JornadasController@index');
        $api->post('/', 'JornadasController@store');
        $api->put('/', 'JornadasController@update');
        $api->delete('/', 'JornadasController@delete');
    }
);