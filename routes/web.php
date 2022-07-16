<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    // Admin all route here
    Route::any('/', [AdminController::class, 'login']);

    // Admin all routes protecetd form admin guard
    Route::group(['middleware' => ['admin']], function(){
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/settings', [AdminController::class, 'settings']);
        Route::get('/logout', [AdminController::class, 'logout']);
        Route::post('/check-current-pwd', [AdminController::class, 'chkCurrentPassword']);
        Route::any('/update-admin-details', [AdminController::class, 'updateAdminDetails']);


        // Section Route
        Route::get('/sections', [SectionController::class, 'sections'])->name('sections');
        Route::post('/update-section-status', [SectionController::class, 'updateSectionStatus']);


        // Category Route
        Route::get('/categories', [CategoryController::class, 'categories']);
        Route::post('/update-categories-status', [CategoryController::class, 'updateCategoryStatus']);
        Route::any('/add-edit-category/{id?}', [CategoryController::class, 'addEditCategory']);
        Route::post('/append-category-level', [CategoryController::class, 'appendCategoryLevel']);
        Route::get('/delete-category-image/{id}', [CategoryController::class, 'deleteCategoryImage']);
        Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory']);

        // Product Route
        Route::get('/products', [ProductController::class, 'products']);
        Route::post('/update-products-status', [ProductController::class, 'updateProductStatus']);
        Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
        Route::any('/add-edit-product/{id?}', [ProductController::class, 'addEditProduct']);
        Route::get('/delete-product-image/{id}', [ProductController::class, 'deleteProductImage']);
        Route::get('/delete-product-video/{id}', [ProductController::class, 'deleteProductVideo']);

        // Attributes
        Route::any('/add-attribute/{id?}', [ProductController::class, 'addAttribute']);

    });
});
