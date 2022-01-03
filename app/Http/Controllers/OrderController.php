<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrder(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->products = unserialize($order->products);
        $productArr = [];
        foreach ($order->products as $ind => $product) {
            $productDetail = Product::findOrFail($product['product_id']);
            $productArr[$ind]['id'] = $productDetail->id;
            $productArr[$ind]['title'] = $productDetail->title;
            $productArr[$ind]['image'] = $productDetail->image;
            $productArr[$ind]['price'] = number_format($productDetail->price, 2);
            $productArr[$ind]['qty'] = $product['product_qty'];
            $productArr[$ind]['total'] = $product['product_qty'] * $productDetail->price;
            $productArr[$ind]['total'] = number_format($productArr[$ind]['total'], 2);
        }
        $order->products = $productArr;
        return response()->json($order);
    }
}
