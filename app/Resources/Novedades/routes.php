<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['namespace' => 'App\Resources\Novedades'],
    function () use ($api) {
        $api->group(['prefix' => 'bonificaciones', 'namespace' => 'Bonificaciones'],function () use ($api) {
            $api->get('/', 'BonificacionesController@index');
            $api->post('/', 'BonificacionesController@store');
            $api->put('/{id}', 'BonificacionesController@update');
            $api->delete('/{id}', 'BonificacionesController@destroy');
        });
        $api->group(['prefix' => 'viajes', 'namespace' => 'Viajes'],function () use ($api) {
            $api->get('/', 'ViajesController@index');
            $api->post('/', 'ViajesController@store');
            $api->put('/{id}', 'ViajesController@update');
            $api->delete('/{id}', 'ViajesController@destroy');
        });
    }
);