<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
        $api->get('role', 'App\\Api\\V1\\Controllers\\RoleController@index');
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {


        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');

        $api->group(['prefix' => 'user'], function(Router $api) {
            $api->get('profile', 'App\\Api\\V1\\Controllers\\UserController@profile');
        });

        $api->group(['prefix' => 'report'], function(Router $api) {
            $api->get('{start}/{end}', 'App\\Api\\V1\\Controllers\\ReportController@index');
        });

        $api->group(['prefix' => 'rack'], function(Router $api) {
            $api->get('', 'App\\Api\\V1\\Controllers\\RackController@index');
            $api->post('create', 'App\\Api\\V1\\Controllers\\RackController@create');
            $api->put('update/{id}', 'App\\Api\\V1\\Controllers\\RackController@update');
            $api->delete('destroy/{id}', 'App\\Api\\V1\\Controllers\\RackController@delete');
        });

        $api->group(['prefix' => 'warehouse'], function(Router $api) {
            $api->get('', 'App\\Api\\V1\\Controllers\\WarehouseController@index');
            $api->post('create', 'App\\Api\\V1\\Controllers\\WarehouseController@create');
            $api->put('update/{id}', 'App\\Api\\V1\\Controllers\\WarehouseController@update');
            $api->delete('destroy/{id}', 'App\\Api\\V1\\Controllers\\WarehouseController@delete');
        });

        $api->group(['prefix' => 'item'], function(Router $api) {
            $api->get('', 'App\\Api\\V1\\Controllers\\ItemController@index');
            $api->post('in', 'App\\Api\\V1\\Controllers\\ItemController@in');
            $api->get('out', 'App\\Api\\V1\\Controllers\\ItemController@indexOut');
            $api->patch('out/{id}', 'App\\Api\\V1\\Controllers\\ItemController@out');
            $api->get('defect', 'App\\Api\\V1\\Controllers\\ItemController@indexDefect');
            $api->patch('defect/{id}', 'App\\Api\\V1\\Controllers\\ItemController@defect');
            $api->delete('destroy/{id}', 'App\\Api\\V1\\Controllers\\ItemController@destroy');
            $api->put('update/{id}', 'App\\Api\\V1\\Controllers\\ItemController@update');
            $api->post('update-photo/{id}', 'App\\Api\\V1\\Controllers\\ItemController@updateItemPhoto');
            $api->get('{id}', 'App\\Api\\V1\\Controllers\\ItemController@show');
        });
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ], 200);
    });
});
