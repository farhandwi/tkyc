<?php

use App\Http\Controllers\DotsApprovalController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UsersImageController;
use App\Http\Controllers\CostCenterHierarchyController;
use App\Http\Controllers\MailHeadCostCenterController;
use App\Http\Middleware\JwtAuthMiddleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;


Route::middleware([JwtAuthMiddleware::class])->group(function () {
    Route::get('/bank-info/{bp}', [EmployeeController::class, 'getBankInfo']);
    Route::get('/get/all-application/{bp}', [EmployeeController::class, 'getAllApplication']);
});
Route::get('/bp/cost-center/{bp}', [EmployeeController::class, 'getCostCenter']);
Route::get('/cost-center', [CostCenterHierarchyController::class, 'getAllCostCenterHierarchy']);
Route::get('/image/{bp}', [UsersImageController::class, 'getImage'])->name('image');

Route::delete('/logout', [EmployeeController::class, 'logout']);
Route::get('/role/{email}', [EmployeeController::class, 'getRole']);
Route::get('/role/all/{email}', [EmployeeController::class, 'getAllRole']);
Route::get('/list-application/{email}', [EmployeeController::class, 'getListApplication']);

Route::post('/image', [UsersImageController::class, 'createOrUpdate']);
Route::get('/bp/email/{email}', [EmployeeController::class, 'getBpEmployee']);
Route::get('/bp/{cost_center}', [EmployeeController::class, 'getBpCostCenter']);
Route::get('/employee', [EmployeeController::class, 'getAllEmployee']);

Route::get('/cost-center-approval/{bp}', [EmployeeController::class, 'getCostCenterApproval']); 

Route::post('/login', [EmployeeController::class, 'login']);
Route::post('/approvers', [EmployeeController::class, 'getApprovers']);

Route::post('/dots-approval', [DotsApprovalController::class, 'getApprovals']);
Route::get('/map-employee-title', [DotsApprovalController::class, 'MapEmployeeTitle']);
Route::post('/dots-approval/multiple', [DotsApprovalController::class, 'getByMultipleCostCenters']);
Route::post('/mail-head-cost-center', [MailHeadCostCenterController::class, 'getCostCenterData']);

Route::middleware(HandleCors::class)->group(function () {
    Route::get('/token', [EmployeeController::class, 'refresh']);
});