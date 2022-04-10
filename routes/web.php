<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ContentController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;


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

Route::get('/admin/dashboard', [ContentController::class, 'index'])->name('dashboard');


// Admin 

// Brand All Routes

Route::prefix('brand')->group(function(){
    Route::get('/view',[BrandController::class, 'BrandView'] )->name('all.brand');
    Route::post('/store',[BrandController::class, 'BrandStore'] )->name('brand.store');
    Route::get('/edit/{id}',[BrandController::class, 'BrandEdit'] )->name('brand.edit');
    Route::post('/update',[BrandController::class, 'BrandUpdate'] )->name('brand.update');
    Route::get('/delete/{id}',[BrandController::class, 'BrandDelete'] )->name('brand.delete');
});



// Category All Routes

Route::prefix('category')->group(function(){
    Route::get('/view',[CategoryController::class, 'CategoryView'] )->name('all.category');
    Route::post('/store',[CategoryController::class, 'CategoryStore'] )->name('category.store');
    Route::get('/edit/{id}',[CategoryController::class, 'CategoryEdit'] )->name('category.edit');
    Route::post('/update',[CategoryController::class, 'CategoryUpdate'] )->name('category.update');
    Route::get('/delete/{id}',[CategoryController::class, 'CategoryDelete'] )->name('category.delete');

// SubCategory Routes

    Route::get('/sub/view',[SubCategoryController::class, 'SubCategoryView'] )->name('all.subcategory');
    Route::post('/sub/store',[SubCategoryController::class, 'SubCategoryStore'] )->name('subcategory.store');
    Route::get('/sub/edit/{id}',[SubCategoryController::class, 'SubCategoryEdit'] )->name('subcategory.edit');
    Route::post('/sub/update',[SubCategoryController::class, 'SubCategoryUpdate'] )->name('subcategory.update');
    Route::get('/sub/delete/{id}',[SubCategoryController::class, 'SubCategoryDelete'] )->name('subcategory.delete');

// Sub_SubCategory Routes
    Route::get('/sub/sub/view',[SubCategoryController::class, 'SubSubCategoryView'] )->name('all.subsubcategory');
    Route::get('/subcategory/ajax/{category_id}',[SubCategoryController::class, 'GetSubCategory'] );
    Route::get('/sub-subcategory/ajax/{subcategory_id}',[SubCategoryController::class, 'GetSubSubCategory'] );
    Route::post('/sub/sub/store',[SubCategoryController::class, 'SubSubCategoryStore'] )->name('subsubcategory.store');
    Route::get('/sub/sub/edit/{id}',[SubCategoryController::class, 'SubSubCategoryEdit'] )->name('subsubcategory.edit');
    Route::post('/sub/sub/update',[SubCategoryController::class, 'SubSubCategoryUpdate'] )->name('subsubcategory.update');
    Route::get('/sub/sub/delete/{id}',[SubCategoryController::class, 'SubSubCategoryDelete'] )->name('subsubcategory.delete');

});



// Products

Route::prefix('product')->group(function(){
    Route::get('/add',[ProductController::class, 'AddProduct'] )->name('add-product');
   
});




