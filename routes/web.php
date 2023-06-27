<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;


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

Route::get('/admin', [
    AdminController::class,
    'loginAdmin'
]);
Route::post('/admin', [
    AdminController::class,
    'postLoginAdmin'
]);

Route::get('/home',function () {
    return view('home');
});

Route::prefix('admin')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [
            CategoryController::class,
            'index'
        ])->name('categories.index');
    
        Route::get('/create', [
            CategoryController::class,
            'create'
        ])->name('categories.create');
    
        Route::post('/store', [
            CategoryController::class,
            'store'
        ])->name('categories.store');
    
        Route::get('/edit/{id}', [
            CategoryController::class,
            'edit'
        ])->name('categories.edit');
    
        Route::post('/update/{id}', [
            CategoryController::class,
            'update'
        ])->name('categories.update');
    
        Route::any('/delete/{id}', [
            CategoryController::class,
            'delete'
        ])->name('categories.delete');
    });
    
    Route::prefix('menus')->group(function () {
        Route::get('/',[
            MenuController::class,
            'index'
        ])->name('menus.index');
    
        Route::get('/create', [
            MenuController::class,
            'create'
        ])->name('menus.create');
    
        Route::post('/store', [
            MenuController::class,
            'store'
        ])->name('menus.store');
    
        Route::get('/edit/{id}', [
            MenuController::class,
            'edit'
        ])->name('menus.edit');
    
        Route::post('/update/{id}', [
            MenuController::class,
            'update'
        ])->name('menus.update');
    
        Route::any('/delete/{id}', [
            MenuController::class,
            'delete'
        ])->name('menus.delete');
    
    });

    Route::prefix('products')->group(function () {
        Route::get('/',[
            AdminProductController::class,
            'index'
        ])->name('products.index');

        Route::get('/create',[
            AdminProductController::class,
            'create'
        ])->name('products.create');

        Route::post('/store',[
            AdminProductController::class,
            'store'
        ])->name('products.store');
    });

});



