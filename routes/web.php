<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
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

Route::view('/login','login');
Route::post('/loggedIn', [\App\Http\Controllers\AuthController::class,'store']);

Route::middleware(['checkUser'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/get-materials', [OrderController::class, 'getMaterials']);
    
    
    Route::get('/logout', [\App\Http\Controllers\AuthController::class,'logout']);
    
    Route::get('/user-lists', [\App\Http\Controllers\AuthController::class,'create']);
    // Route::post('/order-upload', [\App\Http\Controllers\FileUploadController::class,'uploadOrderFile']);
    

    // Route::post('/upload', [\App\Http\Controllers\FileUploadController::class, 'uploadFile'])->name('file.upload');
    
    
    Route::get('/upload', [OrderController::class, 'uploadForm']);
    Route::post('/upload', [OrderController::class, 'uploads'])->name('upload.file');
    Route::get('/order-files', [OrderController::class, 'OrderFiles']);
    Route::get('/order-trail', [OrderController::class, 'OrderTrail']);

    Route::post('/store-material-order', [OrderController::class, 'store']);
    Route::post('/submit-trail-orders', [OrderController::class, 'storeTrailOrders']);
    
    // ✅ Delete Order
Route::delete('/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('order.delete');

Route::get('/edit-trail-order/{id}', [OrderController::class, 'editOrder'])->name('edit-trail-order');

Route::post('/update-order-trail/{id}', [OrderController::class, 'update'])->name('update.order.trail');

    
    // E:\sanket-project\delux-project\resources\views\order_create.blade.php
    // Create Order
    Route::get('/create-order', [OrderController::class, 'createOrder']);
    
    Route::get('/export/orders/{format}', [OrderController::class, 'exportOrders']);
    Route::get('/download/{filename}', [\App\Http\Controllers\FileUploadController::class, 'download'])->name('file.download');
    Route::get('/approvedOrder/{id}', [\App\Http\Controllers\OrderController::class, 'approvedOrder'])
        ->name('order.approve');
});



