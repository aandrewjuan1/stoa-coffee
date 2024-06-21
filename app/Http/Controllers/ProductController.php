<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Handle the validated request data
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Create a new product
        Product::create([
            'name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => 1,
        ]);
        // Redirect or return response
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return view('products.show', ['product' => $product]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        return view('products.edit', ['product' => $product]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {

        if (! $request->hasFile('image')) {
            $imagePath = $product->image;
        } else {
            $imagePath = $request->file('image')->store('images', 'public');
        }   

        // Create a new product
        $product->update([
            'name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => 1,
        ]);
        // Redirect or return response
        return redirect()->route('products.show', ['product' => $product]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return redirect()->route('products.index');
    }
}
