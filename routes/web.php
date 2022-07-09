<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/logar', 'UsersController@login')->name('auth.logar');
// Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('admin')->group(function(){
        Route::get('/settings', 'UsersController@profile');

        Route::get('/users/data', 'UsersController@data');
        Route::resource('/users', 'UsersController');

        Route::get('/rooms/data', 'SalasController@data');
        Route::resource('/rooms', 'SalasController');

        Route::get('/clients/data', 'ClientesController@data');
        Route::resource('/clients', 'ClientesController');

        Route::get('/sweepstakes/data', 'SorteiosController@data');
        Route::resource('/sweepstakes', 'SorteiosController');

        Route::get('/permissions/data', 'PermissionsController@data');
        Route::resource('/permissions', 'PermissionsController');
        
        Route::get('/permission_users/data', 'PermissionsUsersController@data');
        Route::resource('/permission_users', 'PermissionsUsersController');

        Route::resource('/status', 'StatusController');

        Route::get('/pages', function () {
            return view('panel.page');
        });
        
        Route::get('/barracas', function () {
            return view('panel.barracas');
        });
        
    });    
});
