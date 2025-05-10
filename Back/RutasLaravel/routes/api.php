<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParametrosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PedidoController;


use App\Http\Middleware\ApiAuthMiddleware;
use App\Models\Sucursal;
use App\Models\Product;
use App\Models\Notification;

use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test-db', function () {
    $host = DB::select("SELECT @@hostname as host;");
    dd($host);
});


//Usuarios
Route::get('/usuarios/listar/',[UserController::class,'listar'])->middleware(ApiAuthMiddleware::class);
Route::post('/usuarios/crear/',[UserController::class,'crear'])->middleware(ApiAuthMiddleware::class);
Route::post('/usuarios/login/',[UserController::class,'login']);
Route::post('/usuarios/update/',[UserController::class,'update']);

//Route::put('/api/usuarios/update/','UserController@update')->middleware(ApiAuthMiddleware::class);
//Route::post('/api/usuarios/upload/','UserController@upload')->middleware(ApiAuthMiddleware::class);
//Route::get('/api/usuarios/usuarioid/{usuarioid}','UserController@usuarioid')->middleware(ApiAuthMiddleware::class);
//Route::get('/api/usuarios/listar/','UserController@listar')->middleware(ApiAuthMiddleware::class);
//Route::put('/api/usuarios/activar/{usuarioid}','UserController@activar');
//Route::put('/api/usuarios/cambio/','UserController@cambio')->middleware(ApiAuthMiddleware::class);


//Parametro
Route::post('/parametros/crear/',[ParametrosController::class,'crear'])->middleware(ApiAuthMiddleware::class);
Route::get('/parametros/listar/',[ParametrosController::class,'listar'])->middleware(ApiAuthMiddleware::class);
Route::post('/parametros/actualizar/',[ParametrosController::class,'actualizar'])->middleware(ApiAuthMiddleware::class);
Route::put('/parametros/activar/{parametroid}',[ParametrosController::class,'activar'])->middleware(ApiAuthMiddleware::class);
Route::put('/parametros/desactivar/{parametroid}',[ParametrosController::class,'desactivar'])->middleware(ApiAuthMiddleware::class);

//Rol
Route::post('/roles/crear/',[RolesController::class,'crear'])->middleware(ApiAuthMiddleware::class);
Route::get('/roles/listar/',[RolesController::class,'listar'])->middleware(ApiAuthMiddleware::class);
Route::post('/roles/actualizar/',[RolesController::class,'actualizar'])->middleware(ApiAuthMiddleware::class);

//Sucursal
Route::post('/sucursales/crear/',[SucursalesController::class,'crear'])->middleware(ApiAuthMiddleware::class);
Route::get('/sucursales/listar/',[SucursalesController::class,'listar'])->middleware(ApiAuthMiddleware::class);
Route::post('/sucursales/actualizar/',[SucursalesController::class,'actualizar'])->middleware(ApiAuthMiddleware::class);

// Clientes
Route::post('/clientes/crear/',[ClientesController::class,'crear'])->middleware(ApiAuthMiddleware::class);
Route::get('/clientes/listar/',[ClientesController::class,'listar'])->middleware(ApiAuthMiddleware::class);
Route::post('/clientes/actualizar/',[ClientesController::class,'actualizar'])->middleware(ApiAuthMiddleware::class);
Route::post('/clientes/sendmessage/', [ClientesController::class, 'sendmessage']);



//Tad
Route::get('/api/tads/listar/','TadsController@listar');
Route::post('/api/tads/crear/','TadsController@crear')->middleware(ApiAuthMiddleware::class);
Route::put('/api/tads/actualizar/{tadid}','TadsController@actualizar')->middleware(ApiAuthMiddleware::class);

//Autoriza Recibos
Route::get('/api/autorizarecibos/listar/','AutorizaRecibosController@listar');

//Flete
Route::get('/api/fletes/listar/{fecha1}/{fecha2}','FletesController@listar')->middleware(ApiAuthMiddleware::class);
Route::post('/api/fletes/crear/','FletesController@crear')->middleware(ApiAuthMiddleware::class);
Route::post('/api/fletes/actualizar/','FletesController@actualizar')->middleware(ApiAuthMiddleware::class);
Route::put('/api/fletes/eliminar/{fleteid}','FletesController@eliminar')->middleware(ApiAuthMiddleware::class);

// Credito
Route::post('/api/creditos/crear/','CreditosController@crear')->middleware(ApiAuthMiddleware::class);


//relacioncredito
Route::post('/api/relacioncreditos/crear/','RelacionCreditosController@crear')->middleware(ApiAuthMiddleware::class);


//Productos
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);


//Notificaciones
Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);

//Carrito
Route::post('/pedido/agregar-producto', [PedidoController::class, 'agregarProducto']);
Route::get('/pedido/{clienteid}/ver-carrito', [PedidoController::class, 'verCarrito']);













