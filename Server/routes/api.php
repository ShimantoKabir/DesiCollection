<?php

use App\Http\Controllers\AisEntryCtl;
use App\Http\Controllers\ChartOfAccountCtl;
use App\Http\Controllers\MenuPermissionForRoleCtl;
use App\Http\Controllers\RoleCtl;
use App\Http\Controllers\TestCtl;
use App\Http\Controllers\UserInfoCtl;
use App\Http\Controllers\UserWisePermissionCtl;
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
Route::put('/user-infos/{id}', [UserInfoCtl::class, 'update']);

Route::post('/roles/view-init', [RoleCtl::class, 'getInitialData']);
Route::post('/roles', [RoleCtl::class, 'create']);
Route::put('/roles/{oid}', [RoleCtl::class, 'update']);

Route::post('/menu-permission-for-roles/permitted-menus', [MenuPermissionForRoleCtl::class, 'getPermittedMenusByRole']);
Route::post('/menu-permission-for-roles', [MenuPermissionForRoleCtl::class, 'create']);

Route::post('/user-wise-permissions/view-init', [UserWisePermissionCtl::class, 'getInitialData']);
Route::post('/user-wise-permissions/permitted-menus', [UserWisePermissionCtl::class, 'getPermittedMenusByUser']);
Route::put('/user-wise-permissions/{userInfoId}', [UserWisePermissionCtl::class, 'update']);

Route::post('/chart-of-account/view-init', [ChartOfAccountCtl::class, 'getInitialData']);

Route::post('/ais-entry/view-init', [AisEntryCtl::class, 'getInitialData']);


