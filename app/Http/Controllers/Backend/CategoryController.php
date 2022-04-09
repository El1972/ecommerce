<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function CategoryView(){

        $category = Category::latest()->get();
        return view('admin.backend.category.category_view')->with('category', $category);

    }

    public function CategoryStore(Request $request){

        $request->validate([
            'category_name_en' => 'required',
            'category_name_fr' => 'required',
            'category_icon' => 'required'
        ],
        [
            'category_name_en.required' => 'Please enter english category',
            'category_name_fr.required' => 'Please enter french category',
            'category_icon.required' => 'Please enter an icon',

        ]);

        Category::insert([               

            'category_name_en' => $request->category_name_en,
            'category_name_fr' => $request->category_name_fr,
            'category_slug_en' => strtolower(str_replace('','-', $request->category_name_en)),
            'category_slug_fr' => strtolower(str_replace('','-', $request->category_name_fr)),
            'category_icon' => $request->category_icon,
        ]);

        return redirect()->back();

    }



    public function CategoryEdit($id){

        $category = Category::findOrFail($id);
        return view('admin.backend.category.category_edit')->with('category', $category);

    }



    public function CategoryUpdate(Request $request){

        $cat_id = $request->id;

        Category::findOrFail($cat_id)->update([                
            'category_name_en' => $request->category_name_en,
            'category_name_fr' => $request->category_name_fr,
            'category_slug_en' => strtolower(str_replace('','-', $request->category_name_en)),
            'category_slug_fr' => strtolower(str_replace('','-', $request->category_name_fr)),
            'category_icon' => $request->category_icon
        ]);
        return redirect()->route('all.category');

    }



    public function CategoryDelete($id){

        Category::findOrFail($id)->delete();

        return redirect()->route('all.category');

    }
}
