<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Request $request) 
    {
        $product = Product::findOrFail($request->id);
        return view('pages.product', compact('product'));
    }
}
