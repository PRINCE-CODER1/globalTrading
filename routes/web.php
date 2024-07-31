<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UnitOfMeasurementController;
use App\Http\Controllers\StockCategoryController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','verified'])->group(function() {
    Route::get('/dashboard', function () {
        return view('website.master');
    })->name('dashboard');
});     

Route::middleware('auth')->group(function() {

   // Segments Route
   Route::get('segments', function(){
    return view('website.segments.segments');
    })->name('segments.index');

    // Sub-Segments Route
    Route::get('sub-segments', function(){
        return view('website.segments.sub-segments');
    })->name('sub-segments.index');

    // Role Route
    Route::resource('users',UserController::class);

    // Role Route
    Route::resource('roles',RoleController::class);

    // permission  Route
    Route::resource('permissions',PermissionController::class);

    // lead sources  Route
    Route::resource('leads',LeadSourceController::class);

    // Workshop  Route
    Route::resource('workshops',WorkshopController::class);

    // Branch  Route
    Route::resource('branches',BranchController::class);

    // Units Of Measurments  Route
    Route::resource('units',UnitOfMeasurementController::class);

    // Units Of Measurments  Route
    Route::resource('stocks-categories',StockCategoryController::class);

    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
