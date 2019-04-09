@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Product Name:</strong>

    <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" placeholder="Name">

</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Quantity:</strong>

    <input type="text" name="quantity" value="{{ $product->quantity }}" class="form-control" placeholder="Quantity">

</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Category Name:</strong>
    <select name="category_id" class="form-control">
    <option value="">--- Select Category ---</option>
    @foreach ($getProductCategory as  $category)
            <option value="{{ $category['id'] }}" {{ $category['id'] == $product->category_id ? 'selected="selected"' : '' }}>{{ $category['category_name'] }}</option>
    @endforeach
    </select>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

    <strong>Description:</strong>

    <textarea class="form-control" style="height:150px" name="description" placeholder="Detail">{{ $product->description }}</textarea>

</div>

</div>
<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">
<label for="">Multiple File Select</label>
<input type="file" class="form-control" name="image[]" multiple>
<img src="{{ URL::to('/') }}/image/{{ $product['product_images']['image'] }}" width="100px" height="100px" alt=""/>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">

<div class="form-group">

<strong>Web Url:</strong>

<input type="text" name="website_url" value="{{ $product->website_url }}" class="form-control" placeholder="Quantity">

</div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form>
@endsection