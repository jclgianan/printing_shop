<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrintingController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcessController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::redirect('/', '/login');

// Authentication routes
Route::get("/login", [AuthController::class, "login"])
    ->name("login");
Route::post("/login", [AuthController::class, "loginPost"])
    ->name("login.post");
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
Route::post("/register", [AuthController::class, "registerPost"])
    ->name("register.post");
Route::get("/add-new-user", [AuthController::class, "addNewUser"])
    ->name("add-new-user");
Route::middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::post('/users/update/{id}', [AuthController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/delete/{id}', [AuthController::class, 'Destroy'])->name('user.destroy');
        Route::get("/register", [AuthController::class, "register"])->name("register");
        Route::get('/activity-logs', [AuthController::class, 'ActivityLogs'])->name('activity.logs');
    });

Route::middleware(['auth', 'role:admin,editor'])
    ->group(function () {
        Route::get('/main', [AuthController::class, 'index'])->name('main');
        Route::get('/add-new-user', [AuthController::class, 'addNewUser'])->name('add-new-user');
        Route::get('/users', [AuthController::class, 'listUsers'])->name('users.list');
    });

// Protected routes - all require authentication
Route::middleware(['auth'])->group(function () {
    // Main pages
    Route::get("/main", [AuthController::class, "index"])->name("main");
    //Refreshing of Data
    // API endpoints
    Route::get('/api/dashboard/stats', [AuthController::class, 'getDashboardStats'])->name('api.dashboard.stats');
    Route::get('/api/dashboard/activities', [AuthController::class, 'getRecentActivities'])->name('api.dashboard.activities');
    Route::get('/dashboard/inventory-chart', [AuthController::class, 'inventoryChart']);


    Route::get("/printing", [PrintingController::class, "printing"])->name("printing");
    Route::get("/repair", [RepairController::class, "repair"])->name("repair");

    // Inventory Management Routes

    // Main inventory list (grouped by device name)
    Route::get('/inventory', [InventoryController::class, 'inventory'])->name('inventory');
    // Create new inventory item
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
    // View all units of a specific device name
    Route::get('/view/{deviceId}', [InventoryController::class, 'view'])->name('inventory.view');
    // Edit specific inventory item
    Route::get('/edit/{id}', [InventoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::post('/inventory/issue/{id}', [InventoryController::class, 'issue'])->name('inventory.issue');
    Route::post('/inventory/return/{id}', [InventoryController::class, 'return'])->name('inventory.return');
    // Delete specific inventory item
    Route::delete('/destroy/{id}', [InventoryController::class, 'destroy'])->name('destroy');
    // Delete all items with a specific device name (optional)
    Route::delete('/destroy-device/{deviceName}', [InventoryController::class, 'destroyDevice'])->name('destroy-device');
    // Alias for compatibility with your blade file
    Route::delete('/devices/{id}', [InventoryController::class, 'destroy'])->name('devices.destroy');
    // Generate Device ID for new inventory item
    Route::get('/generate-device-id', [InventoryController::class, 'generateDeviceId'])->name('generate-device-id');
    Route::post('/inventory/units/{deviceId}/add', [InventoryController::class, 'addUnits'])->name('inventory.add-units');


    // Forms and processes
    Route::get('/addPrinting', [PrintingController::class, 'printingForm'])->name('printing.form');
    Route::get('/addRepair', [RepairController::class, 'repairForm'])->name('repair.form');
    Route::post('/printTicket', [PrintingController::class, 'printTicketStore'])->middleware('auth')->name('printTicket.store');
    Route::post('/repairTicket', [RepairController::class, 'repairTicketStore'])->middleware('auth')->name('repairTicket.store');

    // Search and filtering
    Route::get("/receiving-search", [PrintingController::class, "receivingSearch"])->name("receiving-search");
    Route::get("/repair-search", [RepairController::class, "repairSearch"])->name("repair-search");
    Route::get('/status-filter', [PrintingController::class, 'statusFilter'])->name('status-filter');
    Route::get('/status-repair-filter', [RepairController::class, 'statusRepairFilter'])->name('status-repair-filter');

    // Printing ticket management
    Route::get('/dashboard', [PrintingController::class, 'dashboard'])->name('dashboard');
    Route::get('/repairDashboard', [RepairController::class, 'repairDashboard'])->name('repairDashboard');
    Route::get('/printing/{id}/edit', [PrintingController::class, 'printEdit'])->middleware('auth')->name('print.edit');
    Route::post('/printing/{id}/update', [PrintingController::class, 'printUpdate'])->middleware('auth')->name('print.update');
    Route::get('/repair/{id}/edit', [RepairController::class, 'repairEdit'])->middleware('auth')->name('repair.edit');
    Route::post('/repair/{id}/update', [RepairController::class, 'repairUpdate'])->middleware('auth')->name('repair.update');
    Route::post('/process/store', [PrintingController::class, 'store'])->name('process.store');
    Route::get('/generate-printTicket-id', [PrintingController::class, 'generatePrintTicketId'])->name('generate.printTicket.id');
    Route::get('/generate-repairTicket-id', [RepairController::class, 'generateRepairTicketId'])->name('generate.repairTicket.id');
    Route::get('/generate-repairDevice-id', [RepairController::class, 'generateRepairDeviceId'])->name('generate.repairDevice.id');

    // Print ticket status management
    Route::post('/print-tickets/{id}/status', [PrintingController::class, 'updateStatus'])->name('print-tickets.update-status');
    Route::post('/repair-tickets/{id}/status', [RepairController::class, 'updateRepairStatus'])->name('repair-tickets.update-status');
});
