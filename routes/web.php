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
//Route::post('buscador/{tipo}', ['uses' => 'page\GeneralController@buscador', 'as' => 'buscador']);
Route::match(['get', 'post'], 'buscador/{tipo}',['as' => 'buscador','uses' => 'page\GeneralController@buscador' ]);

Route::group(['prefix' => 'productos', 'as' => 'productos'], function() {
    Route::get('/', ['uses' => 'page\GeneralController@productos', 'as' => '.productos']);
    Route::get('/{id?}', ['uses' => 'page\GeneralController@familia', 'as' => '.familia']);
});
Route::get('atencion/{id?}', ['uses' => 'page\GeneralController@atencion', 'as' => '.atencion']);

Route::get('producto/{link?}', ['uses' => 'page\GeneralController@producto', 'as' => '.producto']);
Route::get('calidad', 'page\GeneralController@calidad')->name('calidad');
Route::get('descargas', 'page\GeneralController@descargas')->name('descargas');
Route::get('trabaje', 'page\GeneralController@trabaje')->name('trabaje');
Route::get('contacto', 'page\GeneralController@contacto')->name('contacto');

Route::match(['get', 'post'], 'pedido',['uses' => 'page\GeneralController@pedido'])->name("pedido");

Route::get('carrito', 'page\GeneralController@carrito')->name('carrito');
Route::get('registro', 'page\GeneralController@registro')->name('registro');
Route::post('registro', 'page\GeneralController@registroUSER')->name('registroUSER');

Auth::routes();

Route::group(['prefix' => 'cliente', 'as' => 'client.'], function() {
    // Authentication Routes...
    //Route::get('login', 'PrivateArea\LoginController@showLoginForm')->name('login');
    Route::post('acceso', 'PrivateArea\LoginController@login')->name("acceso");
    
    // Route::post('logout', 'PrivateArea\LoginController@logout')->name('logout');
    Route::get('salir', 'PrivateArea\LoginController@logou')->name('salir');
    
    Route::post('register', 'PrivateArea\RegisterController@register')->name('register');
    // Registration Routes...
    // Route::get('register', 'PrivateArea\RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'PrivateArea\RegisterController@register');
    // Password Reset Routes...
    Route::get('password/reset', 'PrivateArea\ForgotPasswordController@showLinkRequestForm')->name('password.forgot');
    Route::post('password/email', 'PrivateArea\ForgotPasswordController@sendResetLinkEmail')->name('password.forgot.post');
    Route::get('password/reset/{token}', 'PrivateArea\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'PrivateArea\ResetPasswordController@reset')->name('password.reset.post');
});

Route::post('form/{seccion}', ['uses' => 'page\FormController@index', 'as' => 'form']);

Route::post('login', 'Auth\LoginController@login')->name("login");
Route::group(['middleware' => 'auth', 'prefix' => 'adm'], function() {
    Route::get('/', 'adm\AdmController@index');
    Route::get('logout', ['uses' => 'adm\AdmController@logout' , 'as' => 'adm.logout']);
    Route::get('export', ['uses' => 'adm\AdmController@export' , 'as' => 'adm.export']);
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
     * PEDIDO
     */
    Route::match(['get', 'post'], 'pedido/create',['uses' => 'adm\PedidoController@create'])->name("pedidoCreate");
    Route::group(['prefix' => 'pedido', 'as' => 'pedido'], function() {
        Route::get('index', ['uses' => 'adm\PedidoController@index', 'as' => '.index']);
        Route::get('confirmar', ['uses' => 'adm\PedidoController@confirmar', 'as' => '.confirmar']);
        Route::post('store', ['uses' => 'adm\PedidoController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\PedidoController@edit', 'as' => '.edit']);
        Route::get('delete/{id}', ['uses' => 'adm\PedidoController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\PedidoController@update', 'as' => 'update']);
    });
    /**
     * CLIENTES
     */
    Route::group(['prefix' => 'clientes', 'as' => 'clientes'], function() {
        Route::get('index', ['uses' => 'adm\ClientesController@index', 'as' => '.index']);
        Route::get('edit/{id}', ['uses' => 'adm\ClientesController@edit', 'as' => '.edit']);
        Route::post('porcentaje/{id}', ['uses' => 'adm\ClientesController@porcentaje', 'as' => '.porcentaje']);
        Route::get('delete/{id}', ['uses' => 'adm\ClientesController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\ClientesController@update', 'as' => 'update']);
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
     * FAMILIAS
     */
    Route::group(['prefix' => 'familias', 'as' => 'familias'], function() {
        Route::get('index', ['uses' => 'adm\FamiliaController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\FamiliaController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\FamiliaController@edit', 'as' => '.edit']);
        Route::get('show/{id?}', ['uses' => 'adm\FamiliaController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\FamiliaController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\FamiliaController@update', 'as' => 'update']);
    });
    /**
     * PARTES
     */
    Route::group(['prefix' => 'partes', 'as' => 'partes'], function() {
        Route::get('index', ['uses' => 'adm\ParteController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\ParteController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\ParteController@edit', 'as' => '.edit']);
        Route::get('show/{id?}', ['uses' => 'adm\ParteController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\ParteController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\ParteController@update', 'as' => 'update']);
    });
    /**
     * TRANSPORTE
     */
    Route::group(['prefix' => 'transporte', 'as' => 'transporte'], function() {
        Route::get('index', ['uses' => 'adm\TransporteController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\TransporteController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\TransporteController@edit', 'as' => '.edit']);
        Route::get('show/{id?}', ['uses' => 'adm\TransporteController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\TransporteController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\TransporteController@update', 'as' => 'update']);
    });
    /**
     * VENDEDOR
     */
    Route::group(['prefix' => 'vendedor', 'as' => 'vendedor'], function() {
        Route::get('index', ['uses' => 'adm\VendedorController@index', 'as' => '.index']);
        Route::post('store', ['uses' => 'adm\VendedorController@store', 'as' => '.store']);
        Route::get('edit/{id}', ['uses' => 'adm\VendedorController@edit', 'as' => '.edit']);
        Route::get('show/{id?}', ['uses' => 'adm\VendedorController@show', 'as' => '.show']);
        Route::get('delete/{id}', ['uses' => 'adm\VendedorController@destroy', 'as' => '.destroy']);
        Route::post('update/{id}', ['uses' => 'adm\VendedorController@update', 'as' => 'update']);
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
    Route::match(['get', 'post'], 'productos/index',['uses' => 'adm\ProductoController@index'])->name("productosIndex");
    Route::group(['prefix' => 'productos', 'as' => 'productos'], function() {
        //Route::match(['get', 'post'], 'productos/index',['uses' => 'adm\ProductoController@index', 'as' => '.index']);
        Route::get('show/{id}', ['uses' => 'adm\ProductoController@show', 'as' => '.show']);
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
        
        Route::group(['prefix' => 'redes', 'as' => '.redes'], function() {
            Route::get('/', ['uses' => 'adm\EmpresaController@redes', 'as' => '.index']);
            Route::post('update/{id}', ['uses' => 'adm\EmpresaController@redesUpdate', 'as' => '.update']);
            Route::post('store', ['uses' => 'adm\EmpresaController@redesStore', 'as' => '.store']);
            Route::get('delete/{id}', ['uses' => 'adm\EmpresaController@redesDestroy', 'as' => '.destroy']);
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
