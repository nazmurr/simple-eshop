<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $sessionItems = \Request::session()->all();
        $cartItems = [];
        $cartTotal = 0;
        $cartTotalUnformat = 0;
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
            $cartTotalUnformat = $cartTotal;
            $cartTotal = number_format($cartTotal, 2);
        }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $stripePaymentIntent = $stripe->paymentIntents->create(
            [
                'amount' => $cartTotalUnformat * 100,
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]
        );
        return view('pages.checkout', compact('cartItems', 'cartTotal', 'stripePaymentIntent'));
    }

    public function processCheckout(Request $request) 
    {
        $input = $request->all();
        $products = $request->session()->get('products');
        if (!$input['customer_id']) {
            $customer = Customer::firstWhere('email', $input['user_email']);
            if ($customer === null) {
                $customer = Customer::create([
                    'first_name' => $input['first_name'],
                    'last_name' => $input['last_name'],
                    'phone' => $input['phone'],
                    'address' => $input['address'],
                    'city' => $input['city'],
                    'zipcode' => $input['zipcode'],
                    'email' => $input['user_email'],
                    'password' => Hash::make($input['user_password']),
                ]);
            }
            $input['customer_id'] = $customer->id;
        }

        $order = Order::create([
            'customer_id' => $input['customer_id'],
            'products' => serialize($products),
            'total' => $this->getOrderTotal($products),
            'status' => 'pending'
        ]);

        $request->session()->forget('products');

        return redirect('/thank-you');
    }

    private function getOrderTotal($products)
    {
        $orderTotal = 0;

        foreach ($products as $ind => $product) {
            $productDetail = Product::findOrFail($product['product_id']);
            $orderTotal += $product['product_qty'] * $productDetail->price;
        }
        
        return $orderTotal;
    }
}
