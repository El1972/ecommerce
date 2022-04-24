<div class="form-group">
    <h5>Main Thumbnail<span class="text-danger">*</span></h5>
    <div class="controls">
        <input type="file" name="image" 
        class="form-control" onChange="mainThamUrl(this)"></div>
        @error('image')
        <span class="text-danger">{{$message}}</span>
        @enderror
        <img src="mainThmb" id="mainThmb">
</div>


<div class="form-group">
    <h5>Multiple Image<span class="text-danger">*</span></h5>
    <div class="controls">
        <input type="file" name="multi_img[]" 
        class="form-control" multiple id="multiImg"></div>
        @error('multi_img')
        <span class="text-danger">{{$message}}</span>
        @enderror
        <div class="row" id="preview_img"></div>
</div>

<div class="form-group">
    <h5>Product Selling Price <span class="text-danger">*</span></h5>
    <div class="controls">
        <input type="text" name="selling_price" 
        class="form-control" value="{{$products->selling_price}}"> </div>
        @error('selling_price')
        <span class="text-danger">{{$message}}</span>
        @enderror
</div>