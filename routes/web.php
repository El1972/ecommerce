<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ContentController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\IndexController;


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


// Frontend

// Load Site

Route::get('/', [IndexController::class, 'index']);




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
    Route::post('/store',[ProductController::class, 'StoreProduct'] )->name('product-store');
    Route::get('/manage',[ProductController::class, 'ManageProduct'] )->name('manage-product');
    Route::get('/edit/{id}',[ProductController::class, 'EditProduct'] )->name('product-edit');
    Route::post('/data/update',[ProductController::class, 'ProductDataUpdate'] )->name('product-update');
    Route::post('/image/update',[ProductController::class, 'MultiImageUpdate'] )->name('update-product-img');
    Route::post('/thumbnail/update',[ProductController::class, 'ThumbnailImageUpdate'] )->name('update-product-thumbnail');
    Route::get('/multiimg/delete/{id}',[ProductController::class, 'MultiImageDelete'] )->name('product.multiimg.delete');
    Route::get('/inactive/{id}',[ProductController::class, 'ProductInactive'] )->name('product-inactive');
    Route::get('/active/{id}',[ProductController::class, 'ProductActive'] )->name('product-active');
    Route::get('/delete/{id}',[ProductController::class, 'ProductDelete'] )->name('product-delete');

});




