<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\Product;
use App\Models\MultiImg;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function AddProduct(){

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.backend.product.product_add', 
                        compact('brands', 'categories'));
    }



    public function StoreProduct(Request $request){

        $request->validate([
            'product_thumbnail' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg|max:5048'
        ],
        [
            'product_thumbnail.required' => 'Please enter english name',
            'image.required' => 'Please enter an image',

        ]);

        $imageName = time().'-'. $request->product_thumbnail . '.' . $request->image->extension();
        $request->image->move(public_path('thumbnails'),$imageName);

        Product::insert([
            'brand_id'=> $request->brand_id,
            'category_id'=> $request->category_id,
            'subcategory_id'=> $request->subcategory_id,
            'subsubcategory_id'=> $request->subsubcategory_id,
            'product_name_en'=> $request->product_name_en,
            'product_name_fr'=> $request->product_name_fr,
            'product_slug_en'=> strtolower(str_replace('', '-', $request->product_slug_en)),
            'product_slug_fr'=> strtolower(str_replace('', '-', $request->product_slug_fr)),
            'product_code'=> $request->product_code,
            'product_qty'=> $request->product_qty,
            'product_tags_en'=> $request->product_tags_en,
            'product_tags_fr'=> $request->product_tags_fr,
            'product_size_en'=> $request->product_size_en,
            'product_size_fr'=> $request->product_size_fr,
            'product_color_en'=> $request->product_color_en,
            'product_color_fr'=> $request->product_color_fr,
            'selling_price'=> $request->selling_price,
            'discount_price'=> $request->discount_price,
            'short_descp_en'=> $request->short_descp_en,
            'short_descp_fr'=> $request->short_descp_fr,
            'long_descp_en'=> $request->long_descp_en,
            'long_descp_fr'=> $request->long_descp_fr,
            'product_thumbnail'=> $request->product_thumbnail,
            'hot_deals'=> $request->hot_deals,
            'featured'=> $request->featured,
            'special_deals'=> $request->special_deals,
            'special_offers'=> $request->special_offers,
            'status' => 1,
            'created_at'=> Carbon::now(),
        ]);

        // Multi Image Upload
        $images = $request->file('multi_img');
        foreach ($images as $img){
            $imageName = time().'-'. $request->multi_img . '.' . $request->img->extension();
            $request->image->move(public_path('multi-img'),$imageName);
            $uploadPath = 'multi-image'.$imageName;
        }
        MultiImg::insert([
            'product_id' => $product_id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),

        ]);
        // End Multi Image Upload

    }
}
