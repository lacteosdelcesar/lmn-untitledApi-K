<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['namespace' => 'App\Resources\Novedades'],
    function () use ($api) {
        //bonificaciones
        $api->group(['prefix' => 'bonificaciones', 'namespace' => 'Bonificaciones'],function () use ($api) {
            $api->get('/', 'BonificacionesController@index');
            $api->post('/', 'BonificacionesController@store');
            $api->put('/{id}', 'BonificacionesController@update');
            $api->delete('/{id}', 'BonificacionesController@destroy');
        });
        //viajes
        $api->group(['prefix' => 'viajes', 'namespace' => 'Viajes'],function () use ($api) {
            $api->get('/', 'ViajesController@index');
            $api->post('/', 'ViajesController@store');
            $api->put('/{id}', 'ViajesController@update');
            $api->delete('/{id}', 'ViajesController@destroy');
        });
        //horas extra
        $api->group(['namespace' => 'JornadasLaborales'],function () use ($api) {
            $api->get('/hlaboradas', 'JornadasLaboralesController@indexHoras');
            $api->group(['prefix' => 'jornadas'],function () use ($api) {
                $api->get('/', 'JornadasLaboralesController@index');
                $api->post('/', 'JornadasLaboralesController@store');
                $api->put('/{id}', 'JornadasLaboralesController@update');
                $api->delete('/{id}', 'JornadasLaboralesController@destroy');
            });
        });
        //periodos
        $api->get('/periodos/actual', 'Periodos\PeriodosController@showActual');
    }
);