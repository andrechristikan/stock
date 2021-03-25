<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
        $api->get('role', 'App\\Api\\V1\\Controllers\\RoleController@index');
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {

        $api->group(['prefix' => 'user'], function(Router $api) {
            $api->get('profile', 'App\\Api\\V1\\Controllers\\UserController@profile');
        });

        $api->group(['prefix' => 'item'], function(Router $api) {
            $api->get('', 'App\\Api\\V1\\Controllers\\ItemController@index');
            $api->post('in', 'App\\Api\\V1\\Controllers\\ItemController@in');
            $api->get('out', 'App\\Api\\V1\\Controllers\\ItemController@indexOut');
            $api->patch('out/{id}', 'App\\Api\\V1\\Controllers\\ItemController@out');
            $api->delete('destroy/{id}', 'App\\Api\\V1\\Controllers\\ItemController@destroy');
            $api->put('update/{id}', 'App\\Api\\V1\\Controllers\\ItemController@update');
            $api->get('{id}', 'App\\Api\\V1\\Controllers\\ItemController@show');
        });

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
