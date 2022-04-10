<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function AddProduct(){

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.backend.product.product_add', 
                        compact('brands', 'categories'));
    }
}
