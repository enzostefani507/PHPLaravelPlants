<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantasController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\ComentarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user/register',[UserController::class,'register']);
Route::post('/user/login',[UserController::class,'login']);
Route::get('/user',[UserController::class,'infouser'])->middleware('auth:sanctum');
Route::put('/user/modificar',[UserController::class,'update'])->middleware('auth:sanctum');
Route::put('/user/foto/borrar',[UserController::class,'borrarImagen'])->middleware('auth:sanctum');
Route::put('/user/foto/agregar',[UserController::class,'cargarImagen'])->middleware('auth:sanctum');
Route::put('/user/foto/modificar',[UserController::class,'updateImagen'])->middleware('auth:sanctum');
Route::get('/user/plantas',[UserController::class,'verPlantas'])->middleware('auth:sanctum');


Route::patch("/plantas/{planta_id}/comentario",[ComentarioController::class,'store'])->middleware('auth:sanctum');

Route::get("/plantas/{planta_id}/comentario",[PlantasController::class,'verComentarios']);
Route::patch("/plantas/agregar-user",[PlantasController::class,'addUsuario'])->middleware('auth:sanctum');;
Route::apiResource("/plantas",PlantasController::class);
