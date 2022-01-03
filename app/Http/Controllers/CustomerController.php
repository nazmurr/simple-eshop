<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
   
    public function showLoginForm()
    {
        if(Auth::guard('customer')->check()) {
            return redirect("/my-account");
        }
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended($request->input('redirect') == 'checkout' ? '/checkout' : '/my-account');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect("/");

    }

    public function accountHistory()
    {
        if(Auth::guard('customer')->check()) {
            $orders = Order::where('customer_id', Auth::guard('customer')->user()->id)->orderBy('id', 'desc')->get();
            return view('pages.myaccount', compact('orders'));
        }
  
        return redirect("/customers/login")->withSuccess('You are not allowed to access');
    }
}
