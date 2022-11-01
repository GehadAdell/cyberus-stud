<?php

use App\Http\Controllers\Photo;
use App\Http\Controllers\Album;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("photo/list",[Photo::class,"index"]);
Route::post("photo/add",[photo::class,"store"]);
Route::post("photo/{id}/delete",[photo::class,"delete"]);
Route::get("photo/{id}",[photo::class,"get"]);
Route::post("photo/{id}/update",[photo::class,"update"]);

Route::get("album/list",[Album::class,"index"]);
Route::post("album/add",[Album::class,"store"]);
Route::post("album/{id}/delete",[Album::class,"delete"]);
Route::get("album/{id}",[Album::class,"get"]);
Route::post("album/{id}/update",[Album::class,"update"]);