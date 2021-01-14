<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\CallController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;

Auth::routes(['verify' => true]);

Route::get('/', function() {
    // return view('index');
    return redirect('/login');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['web']], function() {
    Route::get('storage/{filename}', function ($filename) {
        return Storage::get($filename);
    });
});


Route::get('/start', [MenuController::class, 'start'])->middleware('verified');
Route::get('/getMenus', [MenuController::class, 'getMenus']);
Route::post('/addMenu', [MenuController::class, 'addMenu']);
Route::post('/updateMenu', [MenuController::class, 'updateMenu']);
Route::post('/deleteMenu', [MenuController::class, 'deleteMenu']);


Route::get('/menu/{id}', [MenuController::class, 'menu']);
Route::get('/menu/{id}/edit', [MenuController::class, 'edit']);
Route::get('/menu/{id}/wait', [MenuController::class, 'wait']);


Route::get('/menu/{id}/places', [PlaceController::class, 'places']);
Route::get('/getPlaces/{id}', [PlaceController::class, 'getPlaces']);
Route::post('/addPlace', [PlaceController::class, 'addPlace']);
Route::post('/deletePlace', [PlaceController::class, 'deletePlace']);


Route::get('/menu/{id}/orders', [OrderController::class, 'orders']);
Route::get('/getOrders/{id}', [OrderController::class, 'getOrders']);
Route::get('/getOrder/{id}', [OrderController::class, 'getOrder']);
Route::post('/addOrder', [OrderController::class, 'addOrder']);
Route::post('/updateOrder', [OrderController::class, 'updateOrder']);
Route::post('/deleteOrder', [OrderController::class, 'deleteOrder']);


Route::get('/getCalls/{id}', [CallController::class, 'getCalls']);
Route::post('/addCall', [CallController::class, 'addCall']);
Route::post('/deleteCall', [CallController::class, 'deleteCall']);


Route::get('/getProducts/{id}', [ProductController::class, 'getProducts']);
Route::post('/addProduct', [ProductController::class, 'addProduct']);
Route::post('/updateProduct', [ProductController::class, 'updateProduct']);
Route::post('/changeProductAvailability', [ProductController::class, 'changeProductAvailability']);
Route::post('/deleteProduct', [ProductController::class, 'deleteProduct']);


Route::post('/addSection', [SectionController::class, 'addSection']);
Route::post('/updateSection', [SectionController::class, 'updateSection']);
Route::post('/changeSectionAvailability', [SectionController::class, 'changeSectionAvailability']);
Route::post('/deleteSection', [SectionController::class, 'deleteSection']);


Route::get('/test', [MenuController::class, 'test']);
