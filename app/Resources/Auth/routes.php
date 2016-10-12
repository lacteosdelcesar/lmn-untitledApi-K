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
        $api->get('/refresh_token', 'AuthController@refreshToken');
        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->get('/my', 'UserController@show');
            $api->post('/my/password', 'UserController@changePassword');
        });
        $api->group(['middleware' => 'auth_su'], function ($api) {
            $api->post('/', 'UserController@create');
            $api->get('/', 'UserController@index');
            $api->get('/roles', 'UserController@getRoles');
            $api->put('/{user_id}/reset_password', 'UserController@resetPassword');
        });
    }
);