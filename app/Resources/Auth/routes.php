<?php
/**
 * Created by tav0
 * Date: 8/04/16
 * Time: 12:26 AM
 */

$api->group(
    ['prefix' => 'users', 'namespace' => 'App\Resources\Auth\Controllers'],
    function () use ($api) {
        $api->post('/token', 'AuthController@login');
        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->post('/', 'UserController@create');
            $api->get('/refresh_token', 'AuthController@refreshToken');
            $api->get('/my', 'UserController@show');
            $api->post('/my/password', 'UserController@changePassword');
        });
    }
);