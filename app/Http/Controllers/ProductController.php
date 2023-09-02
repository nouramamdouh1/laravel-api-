<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\storeproductrequest;
use App\Http\Requests\updateproductrequest;
use App\Http\Services\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;  //for middleware in route service provider

use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        // $products=Product::select('id','name'.App::currentlocale());

        // return view('products', compact('products'));
        // return response()->json(compact('products'));
        return $this->data(compact('products'));
        //images must return as url by function getter written in product model
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
         $brands=Brand::select('id','name')->get();
         // return view('createproduct',compact('brands'));
         // return response()->json(compact('brands'));
         return $this->data(compact('brands'));
     }

     /**
      * Store a newly created resource in storage.
      */
     public function store(storeproductrequest $request)
     {
             //insert into database
             $newimagename=Media::upload($request->file('image'),'images\products');
             $data=$request->except('_token' , 'image');
             $data['image']=$newimagename;
             // DB::table('products')->insert($data)


             if(Product::create($data)){
                 // return redirect()->route('index')->with('success','added successfully');
                 // return response()->json(['success'=>true,'message'=>'product Added successfully']);
                 return $this->success('product added successfully');
             }else{
                 // return redirect()->route('products.create')->with('error','can not added ');
                 // return response()->json(['success'=>false,'message'=>'product not created']);
                 return $this->error('product cannot added',['data'=>'failed to update']);
             }
     }

     /**
      * Display the specified resource.
      */
     public function show(Product $product)
     {

     }

     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Product $product)
     {
         $brands=Brand::select('id','name')->get();
         // return view('editproducts',compact('brands','product'));
          // return response()->json(compact('brands'));
         return $this->data(compact('brands','product'));
     }

     /**
      * Update the specified resource in storage.
      */
     public function update(updateproductrequest $request, Product $product)
     {

             if($request->hasfile('image')){
                 $newimagename=Media::upload($request->file('image'),'images\products');
                 $data=$request->except('_token','_method','image');
                 $data['image']=$newimagename;
                     //delete old image from folder
                 $photoname=$product->image;
                 Media::delete(public_path("\images\products\\{$photoname}"));
             }


             if($product->update($data)){
                 // return redirect()->route('index')->with('success','updated successfully');
                 // return response()->json(['success'=>true,'message'=>'product updated successfully']);
                 return $this->success('product updated successfully');
             }else{
                // return redirect()->route('index')->with('error','can not updated ');
                 // return response()->json(['success'=>false,'message'=>'product cannot update']);
                return $this->error('product cannot updated',['data'=>'failed to update']);

            }
    }

     /**
      * Remove the specified resource from storage.
      */
     public function destroy(Product $product)
     {
         $photoname=$product->image;
         Media::delete(public_path("images\products\\{$photoname}"));
        if ($product->delete()) {
         //    return redirect()->route('index')->with('success','deleted successfully');
        // return response()->json(['success'=>true,'message'=>'product deleted']);
         return $this->success('product deleted');
        }else{
            // return redirect()->route('index')->with('error','can not delete ');
             // return response()->json(['success'=>false,'message'=>'product cannot be deleted']);
             return $this->error('product cannot deleted',['data'=>'can not delete']);



     }
 }
 public function getBrand($id)
 {
     // $brand = Brand::find(1);

     // if (!$brand) {
     //     return response()->json(['message' => 'Brand not found'], 404);
     // }

     // $types = $brand->products;

     // return response()->json(compact('types'));
     $brand = Product::find($id)->brand;
     return $this->data(compact('brand'));
     // return dd($products);
 }

}
