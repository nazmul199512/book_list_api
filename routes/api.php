<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\authController;
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

Route::post('/register', [authController::class, 'register']);
Route::post('/login', [authController::class, 'login']);

Route::apiResource( 'posts', PostController::class );


Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::post('/logout', [authController::class, 'logout']);
});



Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );



