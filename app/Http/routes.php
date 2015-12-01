<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Default home route
$router->get('/', 'WelcomeController@index');
$router->get('/home', 'HomeController@index');

// Task Routes
Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@store');
Route::get('/task/{tasker}', 'TaskController@showTask');
Route::delete('/task/{tasker}', 'TaskController@destroy');

// Protected routes, only logged in user can access
$router->group([
    'as'         => 'auth.',
    'namespace'  => 'Auth',
    'prefix'     => 'auth'
], function($router) {

    // Authentication routes...
    $router->get('login', [
        'middleware' => 'guest',
        'as' => 'login',
        'uses' => 'AuthController@showLogin'
    ]);

    $router->post('login', [
        'as' => 'login',
        'middleware' => 'guest',
        'uses'       => 'AuthController@postLogin'
    ]);

    $router->get('logout', [
        'as'         => 'logout',
        'middleware' => 'auth',
        'uses'       => 'AuthController@getLogout',
    ]);

    // Password Routes...
    $router->get('/password/recovery', [
        'as'    => 'recovery',
        'uses'  => 'PasswordController@getEmail'
    ]);

    $router->post('/password/recovery', [
        'as'    => 'recovery',
        'uses'  => 'PasswordController@postEmail'
    ]);

    $router->get('/password/reset/{token}', [
        'as'    => 'reset',
        'uses'  => 'PasswordController@getReset'
    ]);

    $router->post('/password/reset', [
        'as'    => 'reset',
        'uses'  => 'PasswordController@postReset'
    ]);
});



// Protected routes, only logged in user can access
$router->group([
    'middleware' => 'auth',
    'prefix'     => 'dashboard',
    'namespace'  => 'Dashboard',
    'as'         => 'dashboard.'
], function($router) {

    // Users
    $router->group([
        'as'     => 'users.',
        'prefix' => 'users',
    ], function($router) {
        // Domains routes
        $router->get('/', [
            'as' => 'index',
            'uses' => 'UserController@index'
        ]);

        $router->get('create', [
            'as' => 'create', 'uses' => 'UserController@create'
        ]);

        $router->get('{user}/edit', [
            'as' => 'edit', 'uses' => 'UserController@edit'
        ]);

        $router->post('store', [
            'as' => 'store', 'uses' => 'UserController@store'
        ]);

        $router->post('{user}/edit', [
            'as' => 'update', 'uses' => 'UserController@update'
        ]);

        $router->delete('{id}/delete', [
            'as' => 'delete', 'uses' => 'UserController@destroy'
        ]);
    });

    // Domains
    $router->group([
        'as'     => 'domains.',
        'prefix' => 'domains',
    ], function($router) {
        // Domains routes
        $router->get('/', [
            'as' => 'index',
            'uses' => 'DomainController@index'
        ]);

        $router->get('search', [
            'as' => '/',
            'uses' => 'DomainController@search'
        ]);

        $router->get('create', [
            'as' => 'create',
            'uses' => 'DomainController@create'
        ]);

        $router->get('{domain}/edit', [
            'as' => 'edit',
            'uses' => 'DomainController@edit'
        ]);

        $router->get('{domain}/accounts', [
            'as' => 'accounts',
            'uses' => 'DomainController@accounts'
        ]);

        $router->get('{domain}/aliases', [
            'as' => 'aliases',
            'uses' => 'DomainController@aliases'
        ]);

        $router->post('store', [
            'as' => 'store',
            'uses' => 'DomainController@store'
        ]);

        $router->post('{domain}/edit', [
            'as' => 'update',
            'uses' => 'DomainController@update'
        ]);

        $router->delete('{id}/delete', [
            'as' => 'delete',
            'uses' => 'DomainController@destroy'
        ]);

        $router->post('{id}', [
            'as' => 'toggle',
            'uses' => 'DomainController@toggle'
        ]);

        $router->post('{domain}/addAccount', [
            'as' => 'addAccount',
            'uses' => 'DomainController@addAccount'
        ]);

        $router->post('{domain}/addAlias', [
            'as' => 'addAlias',
            'uses' => 'DomainController@addAlias'
        ]);

        $router->delete('{domain_id}/{account_id}/removeAccount', [
            'as' => 'removeAccount',
            'uses' => 'DomainController@removeAccount'
        ]);

        $router->delete('{domain_id}/{alias_id}/removeAlias', [
            'as' => 'removeAlias',
            'uses' => 'DomainController@removeAlias'
        ]);
    });
});



// API Route for Public
$router->group([
    'middleware' => 'auth',
    'namespace'  => 'Api',
    'prefix' => 'api'
], function($router) {

    $router->group([
        'prefix' => 'tasks'
    ], function($router){
        $router->get('/', 'TaskController@index');
        $router->post('/store', 'TaskController@store');
        $router->put('{id}/update', 'TaskController@update');
        $router->put('{id}/toggleDone', 'TaskController@toggleDone');
        $router->delete('/{id}/delete', 'TaskController@destroy');
    });

    $router->group([
        'prefix' => 'comments'
    ], function($router){
        $router->get('/', 'CommentController@index');
        $router->post('/store', 'CommentController@store');
    });

});
