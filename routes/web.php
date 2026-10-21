<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use Illuminate\Support\Facades\Route;


//shared routes
Route::middleware(['auth' , 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Job Vacancy Routes
    Route::resource('/job-vacancy', JobVacancyController::class);
    Route::put('/job-vacancy/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancy.restore');
    
    //Job Application Routes
    Route::resource('/job-application', JobApplicationController::class);
    Route::put('/job-application/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-application.restore');
    

    
});

//company routes
Route::middleware(['auth' , 'role:company-owner'])->group(function () {
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
});
//admin routes
Route::middleware(['auth' , 'role:admin'])->group(function () {
    //User Routes
    Route::resource('/user', UserController::class);
    Route::put('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    
    //Company Routes
    Route::resource('/company', CompanyController::class);
    Route::put('/company/{id}/restore', [CompanyController::class, 'restore'])->name('company.restore');

    // Job Category Routes
    Route::resource('/job-category', JobCategoryController::class);
    Route::put('/job-category/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-category.restore');
    

});
require __DIR__.'/auth.php';
