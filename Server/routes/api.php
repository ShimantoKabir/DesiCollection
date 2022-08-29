<?php

use App\Http\Controllers\AgeCtl;
use App\Http\Controllers\AisEntryCtl;
use App\Http\Controllers\AisReportCtl;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BrandCtl;
use App\Http\Controllers\ChartOfAccountCtl;
use App\Http\Controllers\ColorCtl;
use App\Http\Controllers\FabricCtl;
use App\Http\Controllers\MenuPermissionForRoleCtl;
use App\Http\Controllers\ProductCtl;
use App\Http\Controllers\ProductUserTypeCtl;
use App\Http\Controllers\RoleCtl;
use App\Http\Controllers\SaleCtl;
use App\Http\Controllers\SizeCtl;
use App\Http\Controllers\SupplierAddressCtl;
use App\Http\Controllers\SupplierBillCtl;
use App\Http\Controllers\SupplierCtl;
use App\Http\Controllers\TestCtl;
use App\Http\Controllers\TypeCtl;
use App\Http\Controllers\UserInfoCtl;
use App\Http\Controllers\UserWisePermissionCtl;
use App\Http\Middleware\AdministrationMiddleware;
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

Route::post('/fabrics/index', [FabricCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/fabrics', [FabricCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/fabrics', [FabricCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/fabrics', [FabricCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/sizes/index', [SizeCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/sizes', [SizeCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/sizes', [SizeCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/sizes', [SizeCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/ages/index', [AgeCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/ages', [AgeCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/ages', [AgeCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/ages', [AgeCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/brands/index', [BrandCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/brands', [BrandCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/brands', [BrandCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/brands', [BrandCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/types/index', [TypeCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/types', [TypeCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/types', [TypeCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/types', [TypeCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/user-types/index', [ProductUserTypeCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/user-types', [ProductUserTypeCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/user-types', [ProductUserTypeCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/user-types', [ProductUserTypeCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/products/index', [ProductCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/products', [ProductCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/products', [ProductCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/products', [ProductCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/suppliers/index', [SupplierCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/suppliers', [SupplierCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/suppliers', [SupplierCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/suppliers', [SupplierCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/suppliers/addresses/index', [SupplierAddressCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/suppliers/addresses', [SupplierAddressCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/suppliers/addresses', [SupplierAddressCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/suppliers/addresses', [SupplierAddressCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/supplier-bills/index', [SupplierBillCtl::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/supplier-bills', [SupplierBillCtl::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::put('/supplier-bills', [SupplierBillCtl::class, 'update'])->middleware(AdministrationMiddleware::class);
Route::delete('/supplier-bills', [SupplierBillCtl::class, 'remove'])->middleware(AdministrationMiddleware::class);

Route::post('/sales-offline/index', [BillController::class, 'index'])->middleware(AdministrationMiddleware::class);
Route::post('/sales-offline/calculation', [BillController::class, 'calculate'])->middleware(AdministrationMiddleware::class);
Route::post('/sales-offline', [BillController::class, 'save'])->middleware(AdministrationMiddleware::class);
Route::get('/bills', [BillController::class, 'getBills']);

Route::post('/sales/bill-number', [SaleCtl::class, 'getSalesByBillNumber'])->middleware(AdministrationMiddleware::class);

