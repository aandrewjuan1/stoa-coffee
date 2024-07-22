<?php

namespace App\Http\Controllers;

use App\Models\Customization;
use App\Models\CustomizationItem;
use Illuminate\Http\Request;

class CustomizationController extends Controller
{
    //
    public function create()
    {
        //
        $customizations = Customization::with('customizationItems')->get();
        return view('inventory.customization-create', [
            'customizations' => $customizations,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);
    }
}
