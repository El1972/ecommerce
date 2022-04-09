@extends('admin.admin_master')

@section('admin')

<div class="content-wrapper">
    <div class="container-full">
      <!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content">
        <div class="row">


          {{-- ----------- 3rd Column - Insert Part ---------------- --}}

          <div class="col-12">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Add Category</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                
                    <form action="{{route('category.update', $category->id)}}" method="post">

                      @csrf

                      <input type="hidden" name="id" value="{{$category->id}}">

                    <div class="form-group">
                    <h5>Category Name English<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="category_name_en" 
                      class="form-control" value="{{$category->category_name_en}}">
                      @error('category_name_en')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    </div>

                    <div class="form-group">
                    <h5>Category Name French<span class="text-danger">*</span></h5>
                    <div class="controls">
                      <input type="text" name="category_name_fr" 
                      class="form-control" value="{{$category->category_name_fr}}">
                      @error('category_name_fr')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                    </div>
                    </div>

                    <div class="form-group">
                        <h5>Category Icon<span class="text-danger">*</span></h5>
                        <div class="controls">
                          <input type="text" name="category_icon" 
                          class="form-control" value="{{$category->category_icon}}">
                          @error('category_icon')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                        </div>
                        </div>

                    <div class="text-xs-right">
                      <input type="submit" 
                      class="btn btn-rounded btn-primary mb-5"
                      value="Update">
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