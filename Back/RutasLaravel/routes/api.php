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

//Notificaciones
Route::get('/notifications', [NotificationController::class, 'index']);

// Rutas de API para Pedidos
// Route::post('/api/pedido/','PedidoController@store')->middleware(ApiAuthMiddleware::class);
// Route::post('/api/pedido/',[PedidoController::class,'store'])->middleware(ApiAuthMiddleware::class);
// Route::prefix('api/pedido')->middleware(ApiAuthMiddleware::class)->group(function () {
//     Route::post('/', [PedidoController::class, 'store'])->name('pedido.store'); // Crear un nuevo pedido
//     Route::get('/', [PedidoController::class, 'index'])->name('pedido.index'); // Listar pedidos (opcional)
//     Route::get('/{pedidoid}', [PedidoController::class, 'show'])->name('pedido.show'); // Obtener detalles de un pedido específico (opcional)
// });

// Rutas para manejo de productos en pedidos
// Route::prefix('api/pedido_productos')->middleware(ApiAuthMiddleware::class)->group(function () {
//     Route::post('/', [PedidoController::class, 'addProductToPedido'])->name('pedido.addProduct'); // Agregar producto a un pedido
// });

Route::post('/pedido/agregar-producto', [PedidoController::class, 'agregarProducto']);
Route::get('/pedido/{clienteid}/ver-carrito', [PedidoController::class, 'verCarrito']);













