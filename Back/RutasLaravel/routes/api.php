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
use App\Http\Controllers\HistorialCompraController;
use App\Http\Controllers\NotificacionRepartidorController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\PuntoController;


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
Route::post('/register-user', [UserController::class, 'registerUser']);
Route::get('/get-user-id', [UserController::class, 'getUserIdByEmail']);
Route::get('usuarios/{usuarioid}/puntos', [UserController::class, 'obtenerPuntos']);
Route::put('usuarios/{usuarioid}/puntos', [UserController::class, 'actualizarPuntos']);


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
Route::get('/producto/obtener-id', [ProductController::class, 'obtenerIdPorNombre']);
Route::get('/producto/obtener-cantidad', [ProductController::class, 'getQuantity']);

//Categorias
Route::get('/categories', [CategoryController::class, 'index']);

//Notificaciones
Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);

//Carrito-pedidos
Route::post('/pedido/agregar-producto', [PedidoController::class, 'agregarProducto']);
Route::get('/pedido/{clienteid}/ver-carrito', [PedidoController::class, 'verCarrito']);
Route::put('/pedido/{clienteid}/enviar', [PedidoController::class, 'enviarPedido']);
Route::put('/pedido/{clienteid}/confirmar', [PedidoController::class, 'confirmarPedido']);
Route::get('/conteo-pedidos', [PedidoController::class, 'obtenerConteoPedidos']);
Route::get('/get-pedidos-con-tienda-info', [PedidoController::class, 'getPedidosConTiendaInfo']);
Route::get('/pedidos/{pedidoId}/productos', [PedidoController::class, 'getProductosDePedido']);
Route::get('/totalEnCarrito/{clienteid}', [PedidoController::class, 'getCartProductsCount']);
Route::post('/eliminar-producto', [PedidoController::class, 'eliminarProducto']);


//Historial
Route::post('/historial-compra', [HistorialCompraController::class, 'registrarCompra']);
Route::get('/ingresos-del-dia', [HistorialCompraController::class, 'obtenerIngresosDelDia']);
Route::get('/ingresos-por-dia', [HistorialCompraController::class, 'obtenerIngresosPorDia']);
Route::get('/estadisticas-semanales', [HistorialCompraController::class, 'obtenerEstadisticasSemanales']);
Route::get('/meses', [HistorialCompraController::class, 'obtenerMes']);

//Chat repartidores
Route::get('/mensajes', [NotificacionRepartidorController::class, 'obtenerMensajes']);
Route::post('/mensajes', [NotificacionRepartidorController::class, 'enviarMensaje']);

//Tienda
Route::post('/register-tienda', [TiendaController::class, 'registerTienda']);

//Incidencias
Route::get('/problems', [ProblemController::class, 'index']);
Route::post('/problems', [ProblemController::class, 'store']);
Route::put('/problems/{id}', [ProblemController::class, 'update']);







