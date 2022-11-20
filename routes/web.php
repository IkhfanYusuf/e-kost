<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//PendingAccount
Route::middleware('auth:sanctum')->get('/pending', function () {
    return Inertia::render('PendingAccount');
})->name('pending');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'pending.account',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/{params}', [DashboardController::class, 'search'])->name('dashboard.search');
});

Route::middleware(['not.anak.kost', 'auth:sanctum'])->name('users.')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::patch('/{id}', [UserController::class, 'updateStatus'])->name('update.status');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::delete('/force-delete/{id}', [UserController::class, 'forceDestroy'])->name('force.destroy');
});

Route::middleware(['not.anak.kost', 'auth:sanctum'])->name('users.kost.')->prefix('users-kost')->group(function () {
    Route::get('/', [UserController::class, 'indexKostActive'])->name('index');
    // Route::get('/{id}', [UserController::class, 'show'])->name('show');
    Route::get('/history', [UserController::class, 'indexKostHistory'])->name('history');
});

Route::middleware(['auth:sanctum'])->name('payments.')->prefix('payments')->group(function () {
    Route::middleware('not.anak.kost')->get('/', [PaymentController::class, 'index'])->name('index');
    Route::middleware(['pemilik'])->post('/', [PaymentController::class, 'store'])->name('store');
    Route::middleware(['pemilik'])->patch('/{payment}', [PaymentController::class, 'update'])->name('update');
});

Route::middleware('auth:sanctum')->name('payments.history.')->prefix('payments-history')->group(function () {
    Route::get('/', [PaymentController::class, 'indexHistory'])->name('index');
    // Route::post('/', [PaymentController::class, 'store'])->name('store');
});

Route::middleware(['not.anak.kost', 'auth:sanctum'])->name('rooms.')->prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::get('/create', [RoomController::class, 'create'])->name('create');
    Route::post('/store', [RoomController::class, 'store'])->name('store');
    Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
});

//get rooms on register
Route::post('rooms/find', [RoomController::class, 'roomsByCategory'])->name('find.rooms');

Route::name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/{id}', [HomeController::class, 'show'])->name('show');
});
