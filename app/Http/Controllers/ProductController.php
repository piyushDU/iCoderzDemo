<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productList = Product::with('category', 'product_images')->get();
        return view('home', compact('productList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getProductCategory = ProductCategory::get();
        return view('products.create', compact('getProductCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'website_url' => 'required|url',
        ]);
           
        $saveData = new Product();
        $saveData->product_name = $request['product_name'];
        $saveData->quantity = $request['quantity'];
        $saveData->category_id = $request['category_id'];
        $saveData->description = $request['description'];
        $saveData->website_url = $request['website_url'];  
        $saveData->save(); 
        
        $images=array();
            if($files=$request->file('image')){
            foreach($files as $file){
            $name=$file->getClientOriginalName();
            $file->move('image',$name);
            $images[]=$name;
        
            DB::table('product_images')->insert([
            'product_id' =>  $saveData->id,  
            'image' => $name
            ]);
           
            }
        }
        
        return redirect()->route('home')
                        ->with('status','Product created successfully.');
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $getProductCategory = ProductCategory::get();
        return view('products.edit',compact('product', 'getProductCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'website_url' => 'required|url',
        ]);
         
        $updateData = Product::find($product['id']);
        $updateData->product_name = $request['product_name'];
        $updateData->quantity = $request['quantity'];
        $updateData->category_id = $request['category_id'];
        $updateData->description = $request['description'];
        $updateData->website_url = $request['website_url'];  
        $updateData->update(); 
        
        $images=array();
            if($files=$request->file('image')){
            foreach($files as $file){
            $name=$file->getClientOriginalName();
            $file->move('image',$name);
            $images[]=$name;
        
            DB::table('product_images')->insert([
            'product_id' =>  $updateData->id,  
            'image' => $name
            ]);
           
            }
        }
        
        return redirect()->route('home')
                        ->with('status','Product created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
  
        return redirect()->route('home')
                        ->with('success','Product deleted successfully');
    }

    public function search()
    {
        $name = Request::has('name');
        dd($name);
    }
}
