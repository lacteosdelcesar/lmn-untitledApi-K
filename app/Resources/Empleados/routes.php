<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['prefix' => 'empleados', 'namespace' => 'App\Resources\Empleados\Controllers'],
    function () use ($api) {
        $api->get('/syncup', ['middleware' => 'auth_su', 'uses' => 'SyncController@up']);
        $api->group(['middleware' => 'api.auth'], function () use ($api){
            $api->get('/', 'EmpleadosController@index');
            $api->get('/{cedula}', 'EmpleadosController@show');
            $api->get('/{cedula}/certificado_laboral/{tipo}', 'CertificadosController@create');
        });
        $api->get('/certificado_laboral/{codigo}/pdf', 'CertificadosController@download');
        $api->get('/certificado_laboral/{codigo}', 'CertificadosController@show');
    }
);

$api->get('/areas', ['middleware' => 'auth_su', 'uses' => 'App\Resources\Empleados\Controllers\AreasController@get']);

$api->get('/distritos', 'App\Resources\Empleados\Controllers\DistritosController@index');
