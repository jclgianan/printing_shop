<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

// Protected routes - all require authentication
Route::middleware(['auth'])->group(function () {
    // Main pages
    Route::get("/main", [AuthController::class, "index"])->name("main");
    Route::get("/printing", [AuthController::class, "printing"])->name("printing");
    Route::get("/receiving", [AuthController::class, "receiving"])->name("receiving");
    Route::get("/select-type", [AuthController::class, "selectType"])->name("select-type");
    
    // Forms and processes
    Route::get('/addPrinting', [AuthController::class, 'createForm'])->name('disbursement.form');
    Route::get('/liquidation', [AuthController::class, 'createForm'])->name('liquidation.form');
    Route::post('/process', [AuthController::class, 'store'])->name('process.store');
    
    // Search and filtering
    Route::get("/receiving-search", [AuthController::class, "receivingSearch"])->name("receiving-search");
    Route::get('/category-filter', [AuthController::class, 'categoryFilter'])->name('category-filter');
    
    // Process management
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/process/edit', [AuthController::class, 'edit'])->name('process.edit');
    Route::post('/process/store', [AuthController::class, 'store'])->name('process.store');
    Route::get('/generate-process-id', [AuthController::class, 'generateProcessId'])->name('generate.process.id');
});