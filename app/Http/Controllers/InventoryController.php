<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
    public function index(Product $products)
    {
        $products = Product::all();
        return view('inventory', ['products' => $products]);
    }
}
