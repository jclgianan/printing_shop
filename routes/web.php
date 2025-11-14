<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrintingController;
use App\Http\Controllers\RepairController;
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
Route::get("/register", [AuthController::class, "register"])
    ->name("register");
Route::post("/register", [AuthController::class, "registerPost"])
    ->name("register.post");
Route::get("/add-new-user", [AuthController::class, "addNewUser"])
    ->name("add-new-user");
    
// Protected routes - all require authentication
Route::middleware(['auth'])->group(function () {
    // Main pages
    Route::get("/main", [AuthController::class, "index"])->name("main");
    Route::get("/printing", [PrintingController::class, "printing"])->name("printing");
    Route::get("/repair", [RepairController::class, "repair"])->name("repair");
    Route::get("/select-type", [AuthController::class, "selectType"])->name("select-type");
    
    // Forms and processes
    Route::get('/addPrinting', [PrintingController::class, 'printingForm'])->name('printing.form');
    Route::get('/addRepair', [RepairController::class, 'repairForm'])->name('repair.form');
    Route::post('/printTicket', [PrintingController::class, 'printTicketStore'])->name('printTicket.store');
    Route::post('/repairTicket', [RepairController::class, 'repairTicketStore'])->name('repairTicket.store');
    
    // Search and filtering
    Route::get("/receiving-search", [PrintingController::class, "receivingSearch"])->name("receiving-search");
    Route::get("/repair-search", [RepairController::class, "repairSearch"])->name("repair-search");
    Route::get('/status-filter', [PrintingController::class, 'statusFilter'])->name('status-filter');
    Route::get('/status-repair-filter', [RepairController::class, 'statusRepairFilter'])->name('status-repair-filter');
    
    // Printing ticket management
    Route::get('/dashboard', [PrintingController::class, 'dashboard'])->name('dashboard');
    Route::get('/repairDashboard', [RepairController::class, 'repairDashboard'])->name('repairDashboard');
    Route::get('/printing/{id}/edit', [PrintingController::class, 'printEdit'])->name('print.edit');
    Route::post('/printing/{id}/update', [PrintingController::class, 'printUpdate'])->name('print.update');
    Route::get('/repair/{id}/edit', [RepairController::class, 'repairEdit'])->name('repair.edit');
    Route::post('/repair/{id}/update', [RepairController::class, 'repairUpdate'])->name('repair.update');
    Route::post('/process/store', [PrintingController::class, 'store'])->name('process.store');
    Route::get('/generate-printTicket-id', [PrintingController::class, 'generatePrintTicketId'])->name('generate.printTicket.id');
    Route::get('/generate-repairTicket-id', [RepairController::class, 'generateRepairTicketId'])->name('generate.repairTicket.id');
    
    // Print ticket status management
    Route::post('/print-tickets/{id}/status', [PrintingController::class, 'updateStatus'])->name('print-tickets.update-status');
    Route::post('/repair-tickets/{id}/status', [RepairController::class, 'updateRepairStatus'])->name('repair-tickets.update-status');

});