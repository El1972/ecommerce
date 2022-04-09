<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;


class BrandController extends Controller
{
    public function BrandView(){

        $brands = Brand::latest()->get();

        return view('admin.backend.brand.brand_view')->with('brands', $brands);

    }


    public function BrandStore(Request $request){

        $request->validate([
            'brand_name_en' => 'required',
            'brand_name_fr' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg|max:5048'
        ],
        [
            'brand_name_en.required' => 'Please enter english name',
            'brand_name_fr.required' => 'Please enter french name',
            'image.required' => 'Please enter an image',

        ]);
        

        $imageName = time().'-'. $request->brand_name_en . '.' . $request->image->extension();
        $request->image->move(public_path('images'),$imageName);

        Brand::insert([                 // Insert into:
// database's column names    form 'name' attribute's value names 
            'brand_name_en' => $request->brand_name_en,
            'brand_name_fr' => $request->brand_name_fr,
            'brand_slug_en' => strtolower(str_replace('','-', $request->brand_name_en)),
            'brand_slug_fr' => strtolower(str_replace('','-', $request->brand_name_fr)),
            'brand_image' => $imageName,

        ]);

        return redirect()->back();

    }


    public function BrandEdit($id){

        $brand = Brand::findOrFail($id);
        return view('admin.backend.brand.brand_edit')->with('brand', $brand);

    }

    public function BrandUpdate(Request $request){

        $brand_id = $request->id;
        $old_img = $request->old_image;
        

        if($request->file('image')){

            unlink(public_path('images/') . $old_img);
            $imageName = time().'-'. $request->brand_name_en . '.' . $request->image->extension();
            $request->image->move(public_path('images/'),$imageName);
    
            Brand::findOrFail($brand_id)->update([                
                'brand_name_en' => $request->brand_name_en,
                'brand_name_fr' => $request->brand_name_fr,
                'brand_slug_en' => strtolower(str_replace('','-', $request->brand_name_en)),
                'brand_slug_fr' => strtolower(str_replace('','-', $request->brand_name_fr)),
                'brand_image' => $imageName,
            ]);
            return redirect()->route('all.brand');

        } else {

            Brand::findOrFail($brand_id)->update([                
                'brand_name_en' => $request->brand_name_en,
                'brand_name_fr' => $request->brand_name_fr,
                'brand_slug_en' => strtolower(str_replace('','-', $request->brand_name_en)),
                'brand_slug_fr' => strtolower(str_replace('','-', $request->brand_name_fr)),
            ]);
            return redirect()->route('all.brand');
        }

    }

    public function BrandDelete($id){

        Brand::findOrFail($id)->delete();

        $pic = public_path('images/');

        if(public_path('images/' . $pic)){
            $brand = Brand::findOrFail($id);
            $img = $brand->brand_image;
            unlink(public_path('images/') . $img);
        } else {
            return redirect()->route('all.brand');
        }

        

        
    }
}
