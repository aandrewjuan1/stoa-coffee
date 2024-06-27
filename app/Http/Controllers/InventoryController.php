<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('inventory.index', ['products' => $products]);
    }

    public function search(Request $request)
    {
        // Validate the search query
        $request->validate([
            'query' => 'required|string|min:3', // Example validation rules
        ]);

        // Get the search query from the request
        $searchQuery = $request->input('query');

        // Perform the search
        $products = Product::where('name', 'like', '%'.$searchQuery.'%')
                        ->orWhere('description', 'like', '%'.$searchQuery.'%')
                        ->orWhereHas('categories', function ($query) use ($searchQuery) {
                            $query->where('name', 'like', '%'.$searchQuery.'%');
                        })
                        ->with('categories')
                        ->get();

        // Return the search results view with the filtered products
        return view('inventory.index', ['products' => $products]);
    }

}
