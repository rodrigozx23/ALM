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

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/get', 'AlmacenController@getAllItems');
Route::get('/getP', 'AlmacenController@getAllProductos');
//Route::post('/store','AlmacenController@storeItems');

Route::get('/', function () {
    return view('layouts.app');
});

//ABRE EL MODULO DE ALMACEN
Route::get('/Almacen', function () {
    return view('Almacen.BandejaItemInventario');
});
//LISTAR ALMACEN
Route::get('BandejaAlmacen', 'AlmacenController@listarAlmacen');
//GUARDA EL ITEM
Route::post('guardarItem', 'AlmacenController@storeItem');
Route::post('editarItem', 'AlmacenController@updateItem');

//ABRE EL MODULO DE PRODUCTO
Route::get('/Producto', function () {
    return view('Producto.BandejaProducto');
});

//GUARDA EL PRODUCTO
Route::post('guardarProducto', 'AlmacenController@storeProducto');
Route::post('editarProducto', 'AlmacenController@updateProducto');

//LISTAR Producto
Route::get('BandejaProducto', 'AlmacenController@listarProducto');
//LISTAR ProductoDetalle
Route::get('listarProductoDetalle/{id}', 'AlmacenController@listarProductoDetalle');

Route::post('guardarProductoDetalle', 'AlmacenController@storeProductoDetalle');

Route::post('listarItems', 'AlmacenController@ListarItemsInventario');

//ABRE EL MODULO DE PEDIDO
Route::get('/Pedido', function () {
    return view('/Pedidos/BandejaPedido');
});

Route::post('/listarProducto', 'PedidoController@listarProducto');

Route::post('guardarPedido', 'PedidoController@storePedido');

Route::get('listarPedidoDetalle/{id}', 'PedidoController@listarPedidoDetalle');

Route::get('listarPedidos', 'PedidoController@listarPedidos');

Route::get('cerrarPedido/{id}', 'PedidoController@sellPedido');

Route::get('cancelarPedido/{id}', 'PedidoController@cancelPedido');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
