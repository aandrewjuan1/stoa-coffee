<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // Validate the search and category inputs
        $request->validate([
            'query' => 'nullable|string',
            'category' => 'nullable|integer|exists:categories,id' // Change validation to expect category ID
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
            $categoryId = $request->input('category');

            $productsQuery->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        // Execute the query
        $products = $productsQuery->with('categories')->paginate(20);

        return view('inventory.index', ['products' => $products]);
    }

}
