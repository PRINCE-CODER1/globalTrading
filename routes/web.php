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
use App\Http\Controllers\ChildCategoryController;
use App\Http\Controllers\GodownController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\FinancialYearController;
use App\Http\Controllers\ChallanTypeController;
use App\Http\Controllers\CustomerSupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\StockAgingController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\AgeCategoryController;
use App\Http\Controllers\VisitMasterController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockTransferController;


use App\Mail\StockAgingNotificationEmail;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth','verified'])->group(function() {
    Route::get('/dashboard', function () {
        return view('website.main-erp.index');
    })->name('dashboard.index');
});     

Route::middleware('auth')->group(function() {

   // Segments Route
   Route::get('segments', function(){
    return view('website.master.segments.segments');
    })->name('segments.index');

    // Sub-Segments Route
    Route::get('sub-segments', function(){
        return view('website.master.segments.sub-segments');
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

    // Stock Category  Route
    Route::resource('stocks-categories',StockCategoryController::class);

    // Stock Child-Category  Route
    Route::resource('child-categories', ChildCategoryController::class);

    // Godowns  Route
    Route::resource('godowns',GodownController::class);

    //Tax Route
    Route::resource('taxes',TaxController::class);

    //Master Numbering Route
    Route::resource('master_numbering',FinancialYearController::class);

    //Challan Types Route
    Route::resource('challan-types', ChallanTypeController::class);

    //customer supplier Route
    Route::resource('customer-supplier', CustomerSupplierController::class);

    //customer supplier Route
    Route::resource('products', ProductController::class);

    //Assembly Route
    Route::resource('assemblies', AssemblyController::class);
    
    //Stockaging Route
    Route::resource('age_categories', AgeCategoryController::class);
    
    //Visit Route
    Route::resource('visits', VisitMasterController::class);
    
    //Purpose of visit Route
    Route::resource('series', SeriesController::class);
    
    //Purpose of lead status Route
    Route::resource('leads-status', LeadStatusController::class);
    
    //Assembly Route
    Route::resource('purchase_orders', PurchaseOrderController::class);

    //Purpose of lead status Route
    Route::resource('purchase', PurchaseController::class);

    //Purpose of lead status Route
    Route::resource('sale_orders', SaleOrderController::class);

    //Purpose of lead status Route
    Route::resource('sales', SaleController::class);

    //Purpose of lead status Route
    Route::resource('stock_transfer', StockTransferController::class);

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
