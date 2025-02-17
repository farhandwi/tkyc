<?php

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyJwtToken;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\ApplicationController;
use App\Http\Middleware\VerifyRefreshToken;
use App\Http\Controllers\CostCenterHierarchyController;


Route::get('/accessdenied', function () {
    return view('accessdenied.index');
})->name("accessdenied");

Route::prefix('tkyc')->middleware([VerifyRefreshToken::class])->group(function () {
    // Route::get('/home/{refresh_token}', [HomeController::class, 'dashboard']);
    Route::get('/',  [HomeController::class, 'index']);


    Route::get('/back', function (): RedirectResponse {
        return redirect(env('APP_URL_SSO'));
    })->name("back");


    // ---------------------------------------------------------------- HOME Controller ----------------------------------------------------------------
    Route::get('/home', [HomeController::class, 'index'])->name("home");

    // ---------------------------------------------------------------- EMPLOYEE Controller ----------------------------------------------------------------
    Route::get('/employee', [EmployeeController::class, 'index'])->name("employee");
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name("employeeCreate");
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name("employeeEdit");
    Route::get('/employee/{id}/show', [EmployeeController::class, 'show'])->name("employeeShow");
    Route::post('/employee/store', [EmployeeController::class, 'store'])->name("employeeStore");
    Route::post('/employee/{id}/edit', [EmployeeController::class, 'update'])->name("employeeUpdate");

    Route::get('/employee/{id}/{costCenterId}/{seqNumber}/{titleId}/edit', [EmployeeController::class, 'editEmployeeTitle'])->name("employeeTitleEdit");
    Route::post('/employee/employee/title/edit', [EmployeeController::class, 'updateEmployeeTitle'])->name("employeeTitleUpdate");

    Route::get('/title', [TitleController::class, 'index'])->name("title");
    Route::get('/title/create', [TitleController::class, 'create'])->name("titleCreate");
    Route::post('/title/store', [TitleController::class, 'store'])->name("titleStore");
    Route::get('/title/{id}/show', [TitleController::class, 'show'])->name("titleShow");
    Route::get('/title/{id}/edit', [TitleController::class, 'edit'])->name("titleEdit");
    Route::post('/title/{id}/update', [TitleController::class, 'update'])->name("titleUpdate");

    Route::get('/fetch-titles/{costCenter}', [EmployeeController::class, 'fetchTitles'])->name('fetchTitles');


    // ---------------------------------------------------------------- COST CENTER HIERARCHY Controller ----------------------------------------------------------------
    Route::get('/costcenterhierarchy', [CostCenterHierarchyController::class, 'index'])->name("costCenterHierarchy");
    Route::get('/costcenterhierarchy/create', [CostCenterHierarchyController::class, 'create'])->name("costCenterHierarchyCreate");
    Route::post('/costcenterhierarchy/store', [CostCenterHierarchyController::class, 'store'])->name("costCenterHierarchyStore");

    Route::get('/costcenterhierarchy/{id}/edit', [CostCenterHierarchyController::class, 'edit'])->name("costCenterHierarchyEdit");
    Route::post('/costcenterhierarchy/{id}/update', [CostCenterHierarchyController::class, 'update'])->name("costCenterHierarchyUpdate");
    Route::delete('/costcenterhierarchy/destroy', [CostCenterHierarchyController::class, 'destroy'])->name('costCenterHierarchyDestroy');

    //---------------------------------------------------------------- Mtitle Controller ----------------------------------------------------------------

    Route::get('/title', [TitleController::class, 'index'])->name("title");
    Route::get('/title/create', [TitleController::class, 'create'])->name("titleCreate");
    Route::post('/title/store', [TitleController::class, 'store'])->name("titleStore");
    Route::get('/title/{id}/show', [TitleController::class, 'show'])->name("titleShow");
    Route::get('/title/{id}/edit', [TitleController::class, 'edit'])->name("titleEdit");
    Route::post('/title/{id}/update', [TitleController::class, 'update'])->name("titleUpdate");

    // ---------------------------------------------------------------- COST CENTER Controller ----------------------------------------------------------------
    Route::get('/costcenter', [CostCenterController::class, 'index'])->name("costCenter");
    Route::get('/costcenter/create', [CostCenterController::class, 'create'])->name("costCenterCreate");
    Route::post('/costcenter/store', [CostCenterController::class, 'store'])->name("costCenterStore");
    Route::get('/costcenter/{id}/edit', [CostCenterController::class, 'edit'])->name("costCenterEdit");
    Route::post('/costcenter/{id}/update', [CostCenterController::class, 'update'])->name("costCenterUpdate");
    // ---------------------------------------------------------------- APPLICATION Controller ----------------------------------------------------------------
    Route::get('/application', [ApplicationController::class, 'index'])->name("application");
    Route::get('/application/create', [ApplicationController::class, 'create'])->name("applicationCreate");
    Route::post('/application/store', [ApplicationController::class, 'store'])->name("applicationStore");
    Route::get('/application/{id}/edit', [ApplicationController::class, 'edit'])->name("applicationEdit");
    Route::post('/application/{id}/update', [ApplicationController::class, 'update'])->name("applicationUpdate");
    Route::get('/application/{id}/show', [ApplicationController::class, 'show'])->name("applicationShow");

});

    Route::get('/swagger', function (): Redirector|RedirectResponse {
        return redirect('/api/documentation');
    });

    Route::get('/swagger-prod', function (): Redirector|RedirectResponse {
        return redirect('/tkyc/api/documentation');
    });