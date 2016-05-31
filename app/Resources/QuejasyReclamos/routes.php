<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['namespace' => 'App\Resources\QuejasyReclamos'],
    function () use ($api) {
        $api->group(['prefix' => 'empleados/{cedula}/solicitudes_pqr'],function () use ($api) {
            $api->get('/', 'QuejasyReclamosController@showLast');
            $api->post('/', 'QuejasyReclamosController@store');
        });
        $api->get('/solicitudes_pqr', 'QuejasyReclamosController@index');
        $api->get('/solicitudes_pqr/{pqr_id}', 'QuejasyReclamosController@show');
        $api->delete('/solicitudes_pqr/{pqr_id}', 'QuejasyReclamosController@destroy');
        $api->post('/solicitudes_pqr/{pqr_id}/respuesta', 'QuejasyReclamosController@setRespuesta');
    }
);