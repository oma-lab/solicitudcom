<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:api')->group(function () {
  Route::post('logout', 'Api\AuthController@logout');
  Route::get('solicitud','Api\DataController@solicitud');
  Route::get('solicitudes','Api\DataController@solicitudes');
  Route::get('notificaciones','Api\DataController@notificaciones');
  Route::get('dictamenes','Api\DataController@dictamenes');
  Route::put('recibido/{id}', 'Api\DataController@recibido');
  Route::get('citatorio','Api\DataController@citatorio');
  Route::put('citatorioVisto/{id}', 'Api\DataController@citatorioVisto');
  Route::get('verSolicitud/{id}','Api\DataController@verSolicitud');
});

Route::post('login','Api\AuthController@login');

