<?php

use App\Http\Controllers\TestCtl;
use App\Http\Controllers\UserInfoCtl;
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

Route::get('/test', [TestCtl::class, 'test']);

Route::post('/user-infos/login', [UserInfoCtl::class, 'login']);
Route::post('/user-infos/reload', [UserInfoCtl::class, 'reload']);
Route::post('/user-infos/view-init', [UserInfoCtl::class, 'getInitialData']);
Route::post('/user-infos', [UserInfoCtl::class, 'create']);
