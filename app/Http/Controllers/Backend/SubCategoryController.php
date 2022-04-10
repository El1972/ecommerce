<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubSubcategory;
use App\Models\Subcategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function SubCategoryView(){

        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategory = Subcategory::latest()->get();
        return view('admin.backend.category.subcategory_view')->
        with('subcategory', $subcategory)->with('categories', $categories);

    }


    public function SubCategoryStore(Request $request){

        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_fr' => 'required'
        ],
        [
            'category_id.required' => 'Please enter category',
            'subcategory_name_en.required' => 'Please enter english category',
            'subcategory_name_fr.required' => 'Please enter french category',

        ]);

        Subcategory::insert([               

            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_fr' => $request->subcategory_name_fr,
            'subcategory_slug_en' => strtolower(str_replace('','-', $request->subcategory_name_en)),
            'subcategory_slug_fr' => strtolower(str_replace('','-', $request->subcategory_name_fr)),
        ]);

        return redirect()->back();

    }



    public function SubCategoryEdit($id){

        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategory = Subcategory::findOrFail($id);
        return view('admin.backend.category.subcategory_edit')->
        with('subcategory', $subcategory)->with('categories', $categories);

    }




    public function SubCategoryUpdate(Request $request){

        $subcat_id = $request->id;

        Subcategory::findOrFail($subcat_id)->update([                
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_fr' => $request->subcategory_name_fr,
            'subcategory_slug_en' => strtolower(str_replace('','-', $request->subcategory_name_en)),
            'subcategory_slug_fr' => strtolower(str_replace('','-', $request->subcategory_name_fr)),
        ]);
        return redirect()->route('all.subcategory');

    }



    public function SubCategoryDelete($id){

        Subcategory::findOrFail($id)->delete();

        return redirect()->route('all.subcategory');

    }




    //////////////////////    Sub_SubCategory   //////////////////////////////




    public function SubSubCategoryView(){

        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subsubcategory = SubSubcategory::latest()->get();
        return view('admin.backend.category.subsubcategory_view')->
        with('subsubcategory', $subsubcategory)->with('categories', $categories);

    }



    public function GetSubCategory($category_id){

        $subcat = Subcategory::where('category_id', $category_id)
        ->orderBy('subcategory_name_en', 'ASC')->get();
        return json_encode($subcat);

    }



    public function SubSubCategoryStore(Request $request){

        SubSubcategory::insert([               
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_fr' => $request->subsubcategory_name_fr,
            'subsubcategory_slug_en' => strtolower(str_replace('','-', $request->subsubcategory_name_en)),
            'subsubcategory_slug_fr' => strtolower(str_replace('','-', $request->subsubcategory_name_fr)),
        ]);

        return redirect()->back();

    }




    public function SubSubCategoryEdit($id){

        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name_en', 'ASC')->get();
        $subsubcategories = SubSubCategory::findOrFail($id);
        return view('admin.backend.category.subsubcategory_edit')->
        with('subcategories', $subcategories)->with('subsubcategories', $subsubcategories)->
        with('categories', $categories);
    }




    public function SubSubCategoryUpdate(Request $request){

        $subsubcat_id = $request->id;

        SubSubcategory::findOrFail($subsubcat_id)->update([               
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_fr' => $request->subsubcategory_name_fr,
            'subsubcategory_slug_en' => strtolower(str_replace('','-', $request->subsubcategory_name_en)),
            'subsubcategory_slug_fr' => strtolower(str_replace('','-', $request->subsubcategory_name_fr)),
        ]);

        return redirect()->back();

    }




    public function SubSubCategoryDelete($id){

        SubSubcategory::findOrFail($id)->delete();

        return redirect()->route('all.subsubcategory');

    }




    public function GetSubSubCategory($subcategory_id){



    }

}
