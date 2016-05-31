<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['prefix' => 'empleados', 'namespace' => 'App\Resources\Empleados\Controllers'],
    function () use ($api) {
        $api->get('/', 'EmpleadosController@index');
        $api->get('/syncup', 'SyncController@up');
        $api->get('/{cedula}', 'EmpleadosController@show');
        $api->get('/{cedula}/certificado_laboral/{tipo}', 'CertificadosController@create');
    }
);

$api->get('/probando_probando', 'App\Resources\Empleados\Controllers\EmpleadosController@test');
