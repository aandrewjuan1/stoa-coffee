<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MenuController extends Controller
{
    //
    public function index(Request $request)
    {
            // Validate the search and category inputs
        $request->validate([
            'query' => 'nullable|string|min:3',
            'category' => 'nullable|string|exists:categories,name'
        ]);

        // Start building the query
        $productsQuery = Product::query();

        // Apply search query if present
        if ($request->filled('query')) {
            $searchQuery = $request->input('query');
            $productsQuery->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('categories', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    });
        }

        // Apply category filter if present
        if ($request->filled('category')) {
            $category = $request->input('category');
            $productsQuery->whereHas('categories', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }

        // Paginate the results
        $products = $productsQuery->with('categories')->paginate(6);

        return view('menu.index', ['products' => $products]);
    }


    public function showProduct(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }
}
