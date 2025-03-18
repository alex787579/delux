<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::view('/login', 'login');
Route::post('/loggedIn', [AuthController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout']);

// Middleware-protected Routes
Route::middleware(['checkUser'])->group(function () {
    
    // Dashboard / Home
    Route::get('/', [OrderController::class, 'OrderTrail']);

    // Order Management
    Route::get('/order-list', [OrderController::class, 'uploadForm']);
    Route::get('/pending-order', [OrderController::class, 'PendingOrder']);
    Route::get('/order-trail', [OrderController::class, 'OrderTrail']);
    Route::post('/upload', [OrderController::class, 'uploads'])->name('upload.file');
    Route::post('/store-material-order', [OrderController::class, 'store']);
    Route::post('/submit-trail-orders', [OrderController::class, 'storeTrailOrders']);

    Route::delete('/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('order.delete');
    Route::get('/edit-trail-order/{id}', [OrderController::class, 'editOrder'])->name('edit-trail-order');
    Route::post('/update-order-trail/{id}', [OrderController::class, 'update'])->name('update.order.trail');

    Route::get('/create-order', [OrderController::class, 'createOrder']);
    Route::get('/order-create-admin', [AdminOrderController::class, 'index']);

    Route::get('/export/orders/{format}', [OrderController::class, 'exportOrders']);
    Route::get('/export-order-trail/{format}', [OrderController::class, 'exportOrderTrail']);
    Route::post('/export-orders', [OrderController::class, 'exportOrdersList'])->name('export-orders');

    Route::get('/approvedOrder/{id}', [OrderController::class, 'approvedOrder'])->name('order.approve');

    // Material Management
    Route::get('/get-materials', [OrderController::class, 'getMaterials']);
    Route::get('/get-cart-count', [OrderController::class, 'getCartCount']);

    // User Management
    Route::get('/user-lists', [AuthController::class, 'create']);
    Route::get('/get-users', [AuthController::class, 'getUsers']);

    // File Upload & Download
    Route::get('/download/{filename}', [FileUploadController::class, 'download'])->name('file.download');

    // Admin Order Management
    Route::post('/admin_store-material-order', [AdminOrderController::class, 'store']);
});
