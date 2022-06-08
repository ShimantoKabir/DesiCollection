<?php

use App\Http\Controllers\AgeCtl;
use App\Http\Controllers\AisEntryCtl;
use App\Http\Controllers\AisReportCtl;
use App\Http\Controllers\BrandCtl;
use App\Http\Controllers\ChartOfAccountCtl;
use App\Http\Controllers\ColorCtl;
use App\Http\Controllers\FabricCtl;
use App\Http\Controllers\MenuPermissionForRoleCtl;
use App\Http\Controllers\ProductCtl;
use App\Http\Controllers\ProductUserTypeCtl;
use App\Http\Controllers\RoleCtl;
use App\Http\Controllers\SizeCtl;
use App\Http\Controllers\SupplierAddressCtl;
use App\Http\Controllers\SupplierCtl;
use App\Http\Controllers\TestCtl;
use App\Http\Controllers\TypeCtl;
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

Route::post('/ais/entries/view-init', [AisEntryCtl::class, 'getInitialData']);
Route::post('/ais/entries', [AisEntryCtl::class, 'create']);
Route::get('/ais/entries', [AisEntryCtl::class, 'read']);

Route::post('/ais/report', [AisReportCtl::class, 'showReportByType']);

Route::post('/colors/view-init', [ColorCtl::class, 'getInitialData']);
Route::post('/colors', [ColorCtl::class, 'create']);
Route::put('/colors', [ColorCtl::class, 'update']);
Route::delete('/colors', [ColorCtl::class, 'delete']);

Route::post('/fabrics/index', [FabricCtl::class, 'index']);
Route::post('/fabrics', [FabricCtl::class, 'save']);
Route::put('/fabrics', [FabricCtl::class, 'update']);
Route::delete('/fabrics', [FabricCtl::class, 'remove']);

Route::post('/sizes/index', [SizeCtl::class, 'index']);
Route::post('/sizes', [SizeCtl::class, 'save']);
Route::put('/sizes', [SizeCtl::class, 'update']);
Route::delete('/sizes', [SizeCtl::class, 'remove']);

Route::post('/ages/index', [AgeCtl::class, 'index']);
Route::post('/ages', [AgeCtl::class, 'save']);
Route::put('/ages', [AgeCtl::class, 'update']);
Route::delete('/ages', [AgeCtl::class, 'remove']);

Route::post('/brands/index', [BrandCtl::class, 'index']);
Route::post('/brands', [BrandCtl::class, 'save']);
Route::put('/brands', [BrandCtl::class, 'update']);
Route::delete('/brands', [BrandCtl::class, 'remove']);

Route::post('/types/index', [TypeCtl::class, 'index']);
Route::post('/types', [TypeCtl::class, 'save']);
Route::put('/types', [TypeCtl::class, 'update']);
Route::delete('/types', [TypeCtl::class, 'remove']);

Route::post('/user-types/index', [ProductUserTypeCtl::class, 'index']);
Route::post('/user-types', [ProductUserTypeCtl::class, 'save']);
Route::put('/user-types', [ProductUserTypeCtl::class, 'update']);
Route::delete('/user-types', [ProductUserTypeCtl::class, 'remove']);

Route::post('/products/index', [ProductCtl::class, 'index']);
Route::post('/products', [ProductCtl::class, 'save']);
Route::put('/products', [ProductCtl::class, 'update']);
Route::delete('/products', [ProductCtl::class, 'remove']);

Route::post('/suppliers/index', [SupplierCtl::class, 'index']);
Route::post('/suppliers', [SupplierCtl::class, 'save']);
Route::put('/suppliers', [SupplierCtl::class, 'update']);
Route::delete('/suppliers', [SupplierCtl::class, 'remove']);

Route::post('/suppliers/addresses/index', [SupplierAddressCtl::class, 'index']);
Route::post('/suppliers/addresses', [SupplierAddressCtl::class, 'save']);
Route::put('/suppliers/addresses', [SupplierAddressCtl::class, 'update']);
Route::delete('/suppliers/addresses', [SupplierAddressCtl::class, 'remove']);
