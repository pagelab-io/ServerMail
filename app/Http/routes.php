<?php

$router->get('/', 'WelcomeController@index');   // view for login
$router->get('/home', 'HomeController@index');  // view for index after login

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

    /*// Authentication routes...   ESTO NO SE PARA QUE RAYOS SERVIA
    $router->get('login', [
        'middleware' => 'guest',
        'as' => 'login',
        'uses' => 'AuthController@showLogin'
    ]);*/

    // metodo que hace el proceso de login
    $router->post('login', [
        'as' => 'login',                            // alias
        'middleware' => 'guest',                    // aun no se bien para que es el middleware
        'uses'       => 'AuthController@postLogin'  // método al que va a ir a hacer el proceso de login
    ]);

    // metodo que hace el proceso de logout
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

// API Route for Public
$router->group([
    'middleware' => 'auth',
    'namespace'  => 'Api',
    'prefix' => 'api'
], function($router) {

    // Getting RESTful
    $router->resource('/v1/tasks', 'TaskController');

    // Tasks routes
    $router->group([
        'prefix' => 'tasks'
    ], function($router){
        $router->get('/', 'TaskController@index');
        $router->post('/store', 'TaskController@store');
        $router->put('{id}/update', 'TaskController@updateName');
        $router->put('{id}/toggleDone', 'TaskController@toggleDone');
        $router->delete('/{id}/delete', 'TaskController@destroy');
    });

    // Comments routes
    $router->group([
        'prefix' => 'comments'
    ], function($router){
        $router->get('/', 'CommentController@index');
        $router->post('/store', 'CommentController@store');
    });

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
            'as' => 'create', 'uses' => 'UserController@create' // o.O ?
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

        $router->delete('{domain_id}/{account_id}/removeAccount', [
            'as' => 'removeAccount',
            'uses' => 'DomainController@removeAccount'
        ]);

    });

    // Aliases
    $router->group([
        'as'     => 'domains.',
        'prefix' => 'domains',
    ], function($router) {

        // Aliases routes
        $router->get('{domain}/aliases', [
            'as' => 'aliases',
            'uses' => 'AliasController@aliases'
        ]);

        $router->post('{domain}/addAlias', [
            'as' => 'addAlias',
            'uses' => 'AliasController@addAlias'
        ]);

        $router->delete('{domain_id}/{alias_id}/removeAlias', [
            'as' => 'removeAlias',
            'uses' => 'AliasController@removeAlias'
        ]);

    });

});
