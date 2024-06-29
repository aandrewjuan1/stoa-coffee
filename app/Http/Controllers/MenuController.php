<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MenuController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->has('query'))
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
                            ->paginate(6);
        } 
        if ($request->has('category')) 
        {
            $category = $request->input('category');
        
            $products = Product::query()
                            ->whereHas('categories', function ($query) use ($category) {
                                $query->where('categories.name', $category);
                            })
                            ->paginate(6);
        }
        else 
        {
            $products = Product::with('categories')->paginate(6);
        };

        return view('menu.index', ['products' => $products]);
    }
}
