<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'adm'], function() {
    Route::get('/', 'adm\AdmController@index');
    Route::get('logout', ['uses' => 'adm\AdmController@logout' , 'as' => 'adm.logout']);
    /**
     * CONTENIDO
     */
    Route::group(['prefix' => 'contenido', 'as' => 'contenido'], function() {
        Route::get('{seccion}/index', ['uses' => 'adm\ContenidoController@index', 'as' => '.index']);
        Route::get('{seccion}/edit', ['uses' => 'adm\ContenidoController@edit', 'as' => '.edit']);
        Route::post('{seccion}/update', ['uses' => 'adm\ContenidoController@update', 'as' => 'update']);
    });
    /**
     * SLIDERS
     */
    Route::group(['prefix' => 'slider', 'as' => 'slider'], function() {
        Route::get('{seccion}/index', ['uses' => 'adm\SliderController@index', 'as' => '.index']);
        Route::post('{seccion}/store', ['uses' => 'adm\SliderController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\SliderController@edit', 'as' => '.edit']);
        Route::get('delete/{id}', ['uses' => 'adm\SliderController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\SliderController@update', 'as' => 'update']);
    });

    /**
     * CATEGORIAS
     */
    Route::group(['prefix' => 'categorias', 'as' => 'categorias'], function() {
        Route::get('index', ['uses' => 'adm\CategoriaController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\CategoriaController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\CategoriaController@edit', 'as' => '.edit']);
        Route::get('show/{id}', ['uses' => 'adm\CategoriaController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\CategoriaController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\CategoriaController@update', 'as' => 'update']);

        Route::group(['prefix' => 'subcategorias', 'as' => '.subcategorias'], function() {
            Route::get('index', ['uses' => 'adm\SubcategoriaController@index', 'as' => '.index']);
            Route::post('store', ['uses' => 'adm\SubcategoriaController@store', 'as' => '.store']);
            Route::get('edit/{id}', ['uses' => 'adm\SubcategoriaController@edit', 'as' => '.edit']);
            Route::get('delete/{id}', ['uses' => 'adm\SubcategoriaController@destroy', 'as' => '.destroy']);
            Route::post('update/{id}', ['uses' => 'adm\SubcategoriaController@update', 'as' => 'update']);
        });
    });
});
