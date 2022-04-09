@extends('admin.admin_master')

@section('admin')

<div class="content-wrapper">
    <div class="container-full">
      <!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content">
        <div class="row">

          <div class="col-8">

           <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Brand List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>Brand English</th>
                              <th>Brand French</th>
                              <th>Image</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($brands as $item)
                          <tr>
                              <td>{{$item->brand_name_en}}</td>
                              <td>{{$item->brand_name_fr}}</td>
                              <td><img src="{{asset('images/' . $item->brand_image)}}"
                                style="width: 70px; height: 40px"
                                ></td>
                              <td><a href="{{route('brand.edit', $item->id)}}" class="btn btn-info btn-sm">Edit</a>
                                  <a href="{{route('brand.delete', $item->id)}}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
             
                    </table>
                  </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->

       
            <!-- /.box -->          
          </div>
          <!-- /.col -->


          {{-- ----------- 3rd Column - Insert Part ---------------- --}}

          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Add Brand</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                
                    <form action="{{route('brand.store')}}" method="post" 
                    enctype="multipart/form-data">
                      @csrf

                    <div class="form-group">
                    <h5>Brand Name English<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="brand_name_en" class="form-control">
                      @error('brand_name_en')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    </div>

                    <div class="form-group">
                    <h5>Brand Name French<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="brand_name_fr" class="form-control">
                      @error('brand_name_fr')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    </div>

                    <div class="form-group">
                      <h5>Brand Image<span class="text-danger">*</span></h5>
                      <div class="controls">
                      <input type="file" name="image" 
                      class="form-control">
                      @error('image')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    </div>

                    <div class="text-xs-right">
                      <input type="submit" 
                      class="btn btn-rounded btn-primary mb-5"
                      value="Add New">
                    </div>

                    </form>

                   </div>
               </div>
               <!-- /.box-body -->
             </div>
             <!-- /.box -->
 
        
             <!-- /.box -->          
           </div>

        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    
    </div>
</div>
@endsection