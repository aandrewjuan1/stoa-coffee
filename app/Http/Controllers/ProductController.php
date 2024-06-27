<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(6);
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('products.create', ['categories' => $categories]);
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
        $product = Product::create([
            'name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);


        // Attach categories to the product
        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

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
        $categories = Category::all();
        return view('products.edit', ['product' => $product, 'categories' => $categories]);

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
        ]);

        // Sync categories to the product (detach existing and attach new)
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories); // Sync ensures no duplicates
        } else {
            $product->categories()->detach(); // If no categories selected, detach all
        }
        // Redirect or return response
        return redirect()->route('inventory.index');

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
