<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Request $request) 
    {
        $product = Product::findOrFail($request->id);
        $productRating = Rating::Where('product_id', $product->id)->pluck('rating')->avg();
        $product->rating = round($productRating, 0);
        return view('pages.product', compact('product'));
    }
}
