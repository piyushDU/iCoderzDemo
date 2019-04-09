<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\ProductImage;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input; 

class ProductController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productList = Product::with('category')->orderBy('id', 'desc')->get();
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
            'category' => 'required',
            'description' => 'required',
            'website_url' => 'required|url',
        ]);
           
        $saveData = new Product();
        $saveData->product_name = $request['product_name'];
        $saveData->quantity = $request['quantity'];
        $saveData->category_id = $request['category'];
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
        $getProductImages = ProductImage::where('product_id', $product['id'])->get();
        
        return view('products.edit',compact('product', 'getProductCategory', 'getProductImages'));
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
            'category' => 'required',
            'description' => 'required',
            'website_url' => 'required|url',
        ]);
         
        $updateData = Product::find($product['id']);
        $updateData->product_name = $request['product_name'];
        $updateData->quantity = $request['quantity'];
        $updateData->category_id = $request['category'];
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
                        ->with('status','Product updated successfully.');
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
                        ->with('status','Product deleted successfully');
    }

    public function search()
    {

        $productName = Input::get( 'name' );
        
        $productList = Product::where('product_name','like','%'.$productName.'%')
               ->orWhereHas('category', function($q) use ($productName){
                    return $q->where('category_name','like','%'. $productName . '%');
               })->get();

    
    if(count($productList) > 0)
        return view('home', compact('productList'))->withDetails($productList)->withQuery ( $productName );
    else 
        return view ('home', compact('productList'))->withMessage('No Details found. Try to search again !');
    }
}
