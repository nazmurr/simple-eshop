<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $sessionItems = \Request::session()->all();
        $cartItems = [];
        $cartTotal = 0;
        if (array_key_exists("products", $sessionItems)) {
            foreach ($sessionItems['products'] as $ind => $product) {
                $productDetail = Product::findOrFail($product['product_id']);
                $cartItems[$ind]['id'] = $productDetail->id;
                $cartItems[$ind]['title'] = $productDetail->title;
                $cartItems[$ind]['image'] = $productDetail->image;
                $cartItems[$ind]['price'] = number_format($productDetail->price, 2);
                $cartItems[$ind]['qty'] = $product['product_qty'];
                $cartItems[$ind]['total'] = $product['product_qty'] * $productDetail->price;
                $cartTotal += $cartItems[$ind]['total'];
                $cartItems[$ind]['total'] = number_format($cartItems[$ind]['total'], 2);
            }
            $cartTotal = number_format($cartTotal, 2);
        }
        return view('pages.cart', compact('cartItems', 'cartTotal'));
    }

    public function addToCart(Request $request) 
    {
        $input = $request->only('product_id', 'product_qty');
        $isProductExists = $this->isProductExists($input);
        if ($isProductExists !== -1) {
            $request->session()->increment('products.'.$isProductExists.'.product_qty', $incrementBy = $input['product_qty']);
        } else {
            $request->session()->push('products', $input);
        }
        Session::flash('flash_addtocart_success', 'Product is added to cart.');
        return redirect()->back();
    }

    public function removeFromCart(Request $request)
    {
        $input = $request->only('product_id');
        $isProductExists = $this->isProductExists($input);
        if ($isProductExists !== -1) {
            $request->session()->forget('products.'.$isProductExists);
        } 
        Session::flash('flash_removefromcart_success', 'Product is removed from the cart.');
        return redirect()->back();
    }

    private function isProductExists($newProduct)
    {
        $sessionItems = \Request::session()->all();
        if (array_key_exists("products", $sessionItems)) {
            foreach ($sessionItems['products'] as $ind => $product) {
                if ($product['product_id'] == $newProduct['product_id']) {
                    return $ind;
                }
            }
        }
        return -1;
    }
}
