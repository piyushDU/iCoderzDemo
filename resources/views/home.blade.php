@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <form action="{{ route('search') }}" method="GET" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    
                    <input type="text" class="form-control" name="name"
            placeholder="Search here"> <span class="input-group-btn">
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-search">Search</span>
            </button>
        </span>
                </div>
            </form>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                    </div>
                    @if($productList->isNotEmpty())
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th width="280px">Action</th>
                        </tr>
                        
                        
                        @foreach ($productList as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>{{ $product['category']['category_name'] }}</td>
                            <td>{{ $product['description'] }}</td>
                            <td>
                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
            
                                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                
                                    @csrf
                                    @method('DELETE')
                    
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                 </table>
                 @else 
                         <strong>Sorry!</strong> No Product Found.
                 @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
