<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBrandRequest;

class BrandController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $brands=Brand::with('products')->get();
            return $this->data(compact('brands'));

    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // $ddd=Brand::select('id','name')->get();
    // return $this->data(compact('ddd'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        //validation
        //store data
        $data=$request->validated();
        if (Brand::create($data)) {
           return $this->success('brand created successfully');
        }else {
            return $this->error('brand can not created',['brand'=>'not added']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return $this->data(compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return $this->data(compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBrandRequest $request, Brand $brand)
    {
       //validate

       //update
       $data=$request->validated();
       if ($brand->update($data)) {
         return $this->success('brand updated successfully');
       }else{
        return $this->error('brand update failed');
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {

       if ( $brand->delete()) {
        return $this->success('brand deleted successfully');
       }else {
        return $this->error('brand can not deleted');
       }
    }

    public function getBrandProducts($id)
    {
        // $brand = Brand::find(1);

        // if (!$brand) {
        //     return response()->json(['message' => 'Brand not found'], 404);
        // }

        // $types = $brand->products;

        // return response()->json(compact('types'));
        $products = Brand::find($id)->products->pluck('name','description');
        return $this->data(compact('products'));
        // return dd($products);
    }
}
