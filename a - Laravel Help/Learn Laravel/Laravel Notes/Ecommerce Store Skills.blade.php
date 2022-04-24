
1. Creating Prefixes For Routes And Grouping Them
    @php
        Route::prefix('brand')->group(function(){
            Route::get('/view',[BrandController::class, 'BrandView'] )->
                                    name('all.brand');
        });
    @endphp

{{-- --------------------------------------------------------------------- --}}

2. Using asset() & route()
    href={{asset('backend/css/vendors_css.css')}}
    src={{asset('backend/js/template.js')}} 
    <form action="{{route('brand.store')}}" method="post" 
                 enctype="multipart/form-data">
        @csrf
    </form>

{{-- --------------------------------------------------------------------- --}}

3. Displaying Items

    @foreach ($brands as $item)
    <tr>
        <td>{{$item->brand_name_en}}</td>
        <td>{{$item->brand_name_fr}}</td>
        <td><img src="{{asset($item->brand_image)}}"
        style="width: 70px; height: 40px"
        ></td>
        <td><a href="" class="btn btn-info">Edit</a>
            <a href="" class="btn btn-danger">Delete</a>
    </td>
    </tr>
    @endforeach

{{-- --------------------------------------------------------------------- --}}

4. Making Links Active (highlighted - in the views)

    @php
        $prefix = Request::route()->getPrefix();
        $route = Route::current()->getName();
    @endphp

<li class="{{ ($route == 'dashboard') ? 'active' : ''}}">
    <a href="{{ url('admin/dashboard') }}">
      <i data-feather="pie-chart"></i>
      <span>Dashboard</span>
    </a>
  </li>  
  
  <li class="treeview {{ ($prefix == '/brand') ? 'active' : ''}}">
    <a href="#">
      <i data-feather="message-circle"></i>
      <span>Brands</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-right pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="{{ ($route == 'all.brand') ? 'active' : ''}}">
        <a href={{route('all.brand')}}><i class="ti-more"></i>All Brand</a>
    </li>
    </ul>
  </li>

{{-- --------------------------------------------------------------------- --}}

5. Installing Intervention Image Package (for working with images)

  $url = 'https://image.intervention.io/v2/introduction/installation'

    composer require intervention/image

{{-- --------------------------------------------------------------------- --}}

6. Displaying Validation Error Message

    <div class="form-group">
    <h5>Brand Name English<span class="text-danger">*</span></h5>
    <div class="controls">
      <input type="text" name="brand_name_en" class="form-control">

      @error('brand_name_en')
          <span class="text-danger">{{$message}}</span>
      @enderror

    </div>
    </div>

{{-- --------------------------------------------------------------------- --}}

7. How To Create Custom Validation Messages

    @php
            $request->validate([
    // these are 'name' values from the form
            'brand_name_en' => 'required',
            'brand_name_fr' => 'required',
            'brand_image' => 'required'
        ],[
            'brand_name_en.required' => 'Please enter your info',
            'brand_name_fr.required' => 'Please enter your french',
            'brand_image.required' => 'Your image, please'
        ]);
    @endphp

{{-- --------------------------------------------------------------------- --}}

8. Uploading Image In Database

@php

public function BrandStore(Request $request){

    $request->validate([
        'image' => 'required|mimes:png,jpeg,jpg|max:5048'
    ]);
    
// timestamp-image's name (retrieving from input field).extension (also retrieving)
    $imageName = time().'-'. $request->brand_name_en . '.' . $request->image->extension();

// placing image into 'images folder, created in public folder
    $request->image->move(public_path('images'),$imageName);

    Brand::insert([                
        'brand_image' => $imageName,
    ]);

    return redirect()->back();

}

@endphp

{{-- --------------------------------------------------------------------- --}}

9. Displaying Image From Database In The View

{{-- 'images/' - is a folder manually created in the public folder --}}
<img src="{{asset('images/' . $item->brand_image)}}"
style="width: 70px; height: 40px">


{{-- --------------------------------------------------------------------- --}}

10. Inserting Data In The Database

@php

Brand::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'desription' => $request->input('description'),
        ]);

@endphp


@php

Brand::insert([                 // Insert into:
// database's column names    values from the 'name' atrribute of the form 
            'brand_name_en' => $request->brand_name_en,
            'brand_name_fr' => $request->brand_name_fr,
            'brand_slug_en' => strtolower(str_replace('','-', $request->brand_name_en)),
            'brand_slug_fr' => strtolower(str_replace('','-', $request->brand_name_fr)),
            'brand_image' => $imageName,
        ]);

@endphp

{{-- --------------------------------------------------------------------- --}}

11. Passing Data In The Route, And Displaying Data In The Input Field

    <a href="{{route('brand.edit', $item->id)}}" class="btn btn-info btn-sm">Edit</a>

    @php
    
    public function BrandEdit($id){

        $brand = Brand::findOrFail($id);
        return view('admin.backend.brand.brand_edit')->with('brand', $brand);

    }

    @endphp

    <input type="text" name="brand_name_en" 
    class="form-control" value="{{$brand->brand_name_en}}">

{{-- --------------------------------------------------------------------- --}}

12.  Using Hidden Field, Accessing Data And Updating Image       (143)

    {{-- this $brand->id goes to value!!! ($brand comes from controller) --}}
    <form action="{{route('brand.update', $brand->id)}}" method="post" 
    enctype="multipart/form-data">
      @csrf
    {{-- notice, type 'hidden'!!!  accessing db's column names --}}
    <input type="hidden" name="id" value="{{$brand->id}}">
    <input type="hidden" name="old_image" value="{{$brand->brand_image}}">

    <input type="file" name="image">

    <input type="submit" value="Update">
    </form>


@php

    public function BrandUpdate(Request $request){

        // accessing value of 'id', from the 'name' attribute of the view
        $brand_id = $request->id;
        $old_img = $request->old_image;

        // file() - retrieves uploaded files 
        if($request->file('image')){

            // removes file
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

        } 

    }

@endphp

{{-- --------------------------------------------------------------------- --}}

13. Entering An Icon

    @foreach ($category as $item)
    <tr>
    {{-- Notice!!!  i 'class' is already attached, so enter just a name --}}
        <td><span><i class="{{$item->category_icon}}"></i></span></td>
    </tr>
    @endforeach

                        {{-- fa fa-id-card-o  --}}
    <input type="text" name="category_icon" class="form-control">
    
{{-- --------------------------------------------------------------------- --}}

14. Matching & Adding Subcategory's Category_id Field To Category's Id 

<select name="category_id" class="form-control">
    <option value="" selected="" disabled="">Select Category</option>

    @foreach ($categories as $category)

    <option value="{{$category->id}}" 
        {{$category->id == $subcategory->category_id ? 'selected' : ''}}>
        {{$category->category_name_en}}</option>

    @endforeach

</select>

{{-- --------------------------------------------------------------------- --}}

15. Adding Jquery CDN right into a view file

@extends('admin.admin_master')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="content-wrapper">
   ....
</div>

@endsection

{{-- --------------------------------------------------------------------- --}}

16. Getting data from webservice by using Jquery Ajax

<script type="text/javascript">

    // Declare url globaly for this to work
    var url = "{{ url('/category/subcategory/ajax') }}/";
    
    $(document).ready(function(){
      $('select[name="category_id"]').on('change', function(){
        var category_id = $(this).val();
        if(category_id){
          $.ajax({
            url: url + category_id,
            type: "GET",
            dataType: "json",
            success: function(data){
              var d = $('select[name="subcategory_id"]').empty();
              $.each(data, function(key, value){
                console.log(value);
                $('select[name="subcategory_id"]').append('<option value="' + value.id + ' ">' +
                value.subcategory_name_en + '</option>');
              });
            },
          });
        } else {
          alert('danger');
        }
      });
    }); 
    </script>

{{-- --------------------------------------------------------------------- --}}

17. Json encode method in laravel

@php

// Return response with json_encode method in laravel 
$user = App\Models\User::select('id', 'name', 'email')->get();
return json_encode($user);
// You can simply use the json_encode method to send data in JSON format.

@endphp


{{-- Display JSON format data in html using jQuery each method --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
crossorigin="anonymous"></script>

<script>
    var html = '<ul>';
        $.each(response, function( index, value ) {
        html += '<li>' + value.name +'</li>';
        });
    html += '</ul>';
    $('body').append(html);
</script>
{{-- You can display JSON format data in HTML page using jQuery $.each() 
                                                method. --}}

{{-- --------------------------------------------------------------------- --}}






{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
{{-- --------------------------------------------------------------------- --}}
