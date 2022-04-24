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
            'product_name_en' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg|max:5048'
        ],
        [
            'product_name_en.required' => 'Please enter english name',
            'image.required' => 'Please enter an image',

        ]);

       
        $imagefull = time().'-'. $request->product_name_en . '.' . $request->image->extension();
        $request->image->move(public_path('images'),$imagefull);

        $product_id = Product::insertGetId([
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
            'hot_deals'=> $request->hot_deals,
            'featured'=> $request->featured,
            'product_thumbnail'=> $imagefull,
            'special_deals'=> $request->special_deals,
            'special_offers'=> $request->special_offers,
            'status' => 1,
            'created_at'=> Carbon::now(),
        ]);

             // Multi Image Upload
             $files = [];
             $images = $request->file('multi_img');
             foreach ($request->file('multi_img') as $img){
                 $imageName =  time().'-'. $img . '.' . $img->extension();
                 $t = $img->move(public_path('multi-img'),$imageName);
                 $files = $t;
             }
             MultiImg::insert([
                 'product_id' => $product_id,
                 'photo_name' => $files,
                 'created_at' => Carbon::now(),
     
             ]);
             // End Multi Image Upload

             return redirect()->route('manage-product');
    }


    public function ManageProduct(){
        $products = Product::latest()->get();
        return view('admin.backend.product.product_view',
        compact('products'));
    }

    public function EditProduct($id){

        $multiImgs = MultiImg::where('product_id', $id)->get();

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = Subcategory::latest()->get();
        $subsubcategories = SubSubcategory::latest()->get();
        $products = Product::findOrFail($id);

        return view('admin.backend.product.product_edit',
        compact('brands', 'categories', 'subcategories', 'subsubcategories',
        'products', 'multiImgs'));
    }

    public function ProductDataUpdate(Request $request){

        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
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
            'hot_deals'=> $request->hot_deals,
            'featured'=> $request->featured,
            'special_deals'=> $request->special_deals,
            'special_offers'=> $request->special_offers,
            'status' => 1,
            'created_at'=> Carbon::now(),
        ]);

        return redirect()->route('manage-product');

    }

    public function MultiImageUpdate(Request $request){

        $imgs = $request->multi_img;
        foreach($imgs as $id => $img){      
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);
            $imagefull = time().'-'. $request->product_name_en . '.' . $request->img->extension();
            $request->img->move(public_path('multi-img'),$imagefull);

        MultiImg::where('id', $id)->update([
            'photo_name' => $imagefull,
            'updated_at' => Carbon::now(),
        ]);
        }

    }


    public function ThumbnailImageUpdate(Request $request){

        $pro_id = $request->id;
        $oldImage = $request->old_img;
        unlink($oldImage);
        $imagefull = time().'-'. $request->product_name_en . '.' . $request->img->extension();
        $request->img->move(public_path('multi-img'),$imagefull);

        MultiImg::findOrFail($pro_id)->update([
            'product_thumbnail' => $imagefull,
            'updated_at' => Carbon::now(),
        ]);
    }


    public function MultiImageDelete($id){

        $oldimg = MultiImg::findOrFail($id);
        unlink($oldimg->photo_name);
        MultiImg::findOrFail($id)->delete();
    }



    public function ProductInactive($id){

        Product::findOrFail($id)->update([
            'status' => 0
        ]);

        return redirect()->back();

    }



    public function ProductActive($id){

        Product::findOrFail($id)->update([
            'status' => 1
        ]);

        return redirect()->back();

    }



    public function ProductDelete($id){


        $product = Product::findOrFail($id);
        unlink($product->product_thumbnail);
        Product::findOrFail($id)->delete();

        $images = MultiImg::where('product_id', $id)->get();
        foreach($images as $img){
            unlink($img->photo_name);
            MultiImg::where('product_id', $id)->delete();
        }

        return redirect()->back();
    }

}
