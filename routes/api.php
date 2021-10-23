<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantasController;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ComentarioController;
TengoPlantaController

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
Route::post('/user/register',[AuthController::class,'register']);
Route::post('/user/login',[AuthController::class,'login']);
Route::get('/user',[AuthController::class,'infouser'])->middleware('auth:sanctum');
Route::put('/user/modificar',[AuthController::class,'update'])->middleware('auth:sanctum');
Route::put('/user/foto/borrar',[AuthController::class,'borrarImagen'])->middleware('auth:sanctum');
Route::put('/user/foto/agregar',[AuthController::class,'cargarImagen'])->middleware('auth:sanctum');
Route::put('/user/foto/modificar',[AuthController::class,'updateImagen'])->middleware('auth:sanctum');
Route::patch("/plantas/{planta_id}/comentario",[ComentarioController::class,'store'])->middleware('auth:sanctum');
Route::get("/plantas/{planta_id}/comentario",[PlantasController::class,'verComentarios']);
Route::apiResource("/plantas",PlantasController::class);
