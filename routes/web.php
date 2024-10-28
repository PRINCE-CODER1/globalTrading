<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Admin Controller
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
use App\Http\Controllers\CrmController;
use App\Http\Controllers\ChalaanController;
use App\Http\Controllers\ExternalChalaanController;
use App\Http\Controllers\InternalChalaanController;
use App\Http\Controllers\ReturnChalaanController;


// Agent Controller 
use App\Http\Controllers\AgentController;
use App\Http\Controllers\LeadController;

// Manager Controller 
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManagerTeamController;



use App\Mail\StockAgingNotificationEmail;
use Illuminate\Support\Facades\Mail;


// Landing page (auth/login)
Route::get('/', function () {
    return view('auth.login');
});

// Group routes for authenticated and verified users
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Single dashboard route that dynamically redirects based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Dynamically redirect based on role
        if ($user->hasRole('Super Admin')) {
            return view('website.main-erp.index');
        } elseif ($user->hasRole('Agent')) {
            return redirect()->route('agent.dashboard');
        } elseif ($user->hasRole('Manager')) {
            return redirect()->route('manager.dashboard');
        } else {
            // Unauthorized access handling for roles without a dashboard
            abort(403, 'Unauthorized access');
        }
    })->name('dashboard.index');
    

    // Agent-specific routes
    Route::middleware(['auth','role:Agent'])->group(function () {
        Route::get('/agent/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
        Route::resource('/agent/leads',LeadController::class, ['as' => 'agent']);
    });

    // Manager-specific routes
    Route::middleware(['auth', 'role:Manager|Super Admin'])->group(function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
        
        // Show leads created by managers
        Route::get('/managers/{managerId}/leads', [ManagerController::class, 'showManagerLeads'])
            ->name('managers.leads'); // Ensure the user is a 'Manager'
        
        // Nested manager routes
        Route::prefix('manager')->group(function () {
            Route::resource('teams', ManagerTeamController::class)->except(['show']);
            
            Route::get('teams/{team}/assign-agents', [ManagerTeamController::class, 'showAssignForm'])
                ->name('manager.teams.show-assign-form');
            // Route::get('leads', [ManagerTeamController::class, 'showManagerLeads'])
            //     ->name('manager.leads');
            Route::post('teams/{team}/assign-agents', [ManagerTeamController::class, 'assignAgents'])
                ->name('manager.teams.assign-agents');
    
            // Manager viewing agent leads
            Route::get('/agents/{userId}/leads', [ManagerController::class, 'showLeads'])
                ->name('agents.leads');
        });
    });
    

    // Lead Management Routes
    Route::middleware(['auth','role:Manager|Agent|Super Admin'])->group(function () {
        Route::resource('/agent/leads',LeadController::class, ['as' => 'agent']);
        Route::resource('leads', LeadController::class, ['as' => 'manager']);

    });

 // Admin-specific routes
 Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('website.main-erp.index');
    })->name('admin.dashboard');

    // Resourceful routes (users, roles, permissions, etc.)
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('leads', LeadSourceController::class);
    Route::resource('workshops', WorkshopController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('units', UnitOfMeasurementController::class);
    Route::resource('stocks-categories', StockCategoryController::class);
    Route::resource('child-categories', ChildCategoryController::class);
    Route::resource('godowns', GodownController::class);
    Route::resource('taxes', TaxController::class);
    Route::resource('master-numbering', FinancialYearController::class);
    Route::resource('challan-types', ChallanTypeController::class);
    Route::resource('customer-supplier', CustomerSupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('assemblies', AssemblyController::class);
    Route::resource('age-categories', AgeCategoryController::class);
    Route::resource('visits', VisitMasterController::class);
    Route::resource('series', SeriesController::class);
    Route::resource('leads-status', LeadStatusController::class);
    Route::resource('purchase_orders', PurchaseOrderController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('sale_orders', SaleOrderController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('stock_transfer', StockTransferController::class);
    Route::resource('crm', CrmController::class);
    Route::resource('chalaan', ChalaanController::class);
    Route::resource('challan/external', ExternalChalaanController::class);
    Route::resource('challan/internal', InternalChalaanController::class);
    Route::resource('return-chalaan', ReturnChalaanController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Segments and Sub-Segments
    Route::get('segments', function(){
        return view('website.master.segments.segments');
    })->name('segments.index');

    Route::get('sub-segments', function(){
        return view('website.master.segments.sub-segments');
    })->name('sub-segments.index');
});
});

require __DIR__.'/auth.php';