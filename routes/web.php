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

Route::get('/', 'page\GeneralController@index')->name('index');
Route::get('empresa', 'page\GeneralController@empresa')->name('empresa');
Route::group(['prefix' => 'productos', 'as' => 'productos'], function() {
    Route::get('/', ['uses' => 'page\GeneralController@productos', 'as' => '.productos']);
    Route::get('/{id?}', ['uses' => 'page\GeneralController@familia', 'as' => '.familia']);
});
Route::get('producto/{link?}', ['uses' => 'page\GeneralController@producto', 'as' => '.producto']);
Route::get('calidad', 'page\GeneralController@calidad')->name('calidad');

Auth::routes();

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
     * MARCAS
     */
    Route::group(['prefix' => 'marcas', 'as' => 'marcas'], function() {
        Route::get('index', ['uses' => 'adm\MarcasController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\MarcasController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\MarcasController@edit', 'as' => '.edit']);
        Route::get('show/{id}', ['uses' => 'adm\MarcasController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\MarcasController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\MarcasController@update', 'as' => 'update']);

        Route::group(['prefix' => 'modelos', 'as' => '.modelos'], function() {
            Route::get('index', ['uses' => 'adm\MarcasController@index', 'as' => '.index']);
            Route::post('store', ['uses' => 'adm\MarcasController@store', 'as' => '.store']);
            Route::get('edit/{id}', ['uses' => 'adm\MarcasController@edit', 'as' => '.edit']);
            Route::get('delete/{id}', ['uses' => 'adm\MarcasController@destroy', 'as' => '.destroy']);
            Route::post('update/{id}', ['uses' => 'adm\MarcasController@update', 'as' => 'update']);
        });
    });
    /**
     * ORIGENES
     */
    Route::group(['prefix' => 'origenes', 'as' => 'origenes'], function() {
        Route::get('index', ['uses' => 'adm\OrigenesController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\OrigenesController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\OrigenesController@edit', 'as' => '.edit']);
        Route::get('delete/{id}', ['uses' => 'adm\OrigenesController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\OrigenesController@update', 'as' => 'update']);
    });
    /**
     * ORIGENES
     */
    Route::group(['prefix' => 'descargas', 'as' => 'descargas'], function() {
        Route::get('index', ['uses' => 'adm\DescargasController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\DescargasController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\DescargasController@edit', 'as' => '.edit']);
        Route::get('delete/{id}', ['uses' => 'adm\DescargasController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\DescargasController@update', 'as' => 'update']);
    });
    /**
     * RECURSOS
     */
    Route::group(['prefix' => 'recursos', 'as' => 'recursos'], function() {
        Route::get('index', ['uses' => 'adm\RecursosController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\RecursosController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\RecursosController@edit', 'as' => '.edit']);
        Route::get('delete/{id}', ['uses' => 'adm\RecursosController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\RecursosController@update', 'as' => 'update']);
    });
    /**
     * CATEGORIAS
     */
    Route::group(['prefix' => 'categorias', 'as' => 'categorias'], function() {
        Route::get('index', ['uses' => 'adm\CategoriaController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\CategoriaController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\CategoriaController@edit', 'as' => '.edit']);
        Route::get('show/{id}/{tipo}', ['uses' => 'adm\CategoriaController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\CategoriaController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\CategoriaController@update', 'as' => 'update']);

        Route::group(['prefix' => 'subcategorias', 'as' => '.subcategorias'], function() {
            Route::get('index', ['uses' => 'adm\SubcategoriaController@index', 'as' => '.index']);
            Route::post('store', ['uses' => 'adm\SubcategoriaController@store', 'as' => '.store']);
            Route::get('edit/{id}', ['uses' => 'adm\SubcategoriaController@edit', 'as' => '.edit']);
            Route::get('show/{id?}', ['uses' => 'adm\SubcategoriaController@show', 'as' => '.show']);
            Route::get('delete/{id}', ['uses' => 'adm\SubcategoriaController@destroy', 'as' => '.destroy']);
            Route::post('update/{id}', ['uses' => 'adm\SubcategoriaController@update', 'as' => 'update']);
        });
    });

    Route::group(['prefix' => 'productos', 'as' => 'productos'], function() {
        Route::get('index', ['uses' => 'adm\ProductoController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\ProductoController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\ProductoController@edit', 'as' => '.edit']);
        Route::get('delete/{id}', ['uses' => 'adm\ProductoController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\ProductoController@update', 'as' => 'update']);
    });
    
    /**
     * DATOS
     */
    Route::group(['prefix' => 'empresa', 'as' => 'empresa'], function() {
        Route::get('datos', ['uses' => 'adm\EmpresaController@datos', 'as' => '.datos']);
        Route::get('terminos', ['uses' => 'adm\EmpresaController@terminos', 'as' => '.terminos']);
        Route::post('update', ['uses' => 'adm\EmpresaController@update', 'as' => '.update']);

        Route::group(['prefix' => 'metadatos', 'as' => '.metadatos'], function() {
            Route::get('/', ['uses' => 'adm\MetadatosController@index', 'as' => '.index']);
            Route::get('edit/{page}', ['uses' => 'adm\MetadatosController@edit', 'as' => '.edit']);
            Route::post('update/{page}', ['uses' => 'adm\MetadatosController@update', 'as' => '.update']);
            Route::post('store', ['uses' => 'adm\MetadatosController@store', 'as' => '.store']);
            Route::get('delete/{page}', ['uses' => 'adm\MetadatosController@destroy', 'as' => '.destroy']);
        });
        Route::group(['prefix' => 'usuarios', 'as' => '.usuarios'], function() {
            Route::get('/', ['uses' => 'adm\UserController@index', 'as' => '.index']);
            Route::get('datos', ['uses' => 'adm\UserController@datos', 'as' => '.datos']);
            Route::get('edit/{id}', ['uses' => 'adm\UserController@edit', 'as' => '.edit']);
            Route::post('update/{id}', ['uses' => 'adm\UserController@update', 'as' => '.update']);
            Route::post('store', ['uses' => 'adm\UserController@store', 'as' => '.store']);
            Route::get('delete/{id}', ['uses' => 'adm\UserController@destroy', 'as' => '.destroy']);
        });
    });
});
