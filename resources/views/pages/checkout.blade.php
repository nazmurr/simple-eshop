@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<style>
    .alignright {
        text-align: right;
    }
</style>
<div class="container mt-5">
    <div class="row align-items-start">
        
        <div class="col-12">
            <h1 class="mb-3">Checkout</h1>
            <form action="/process-checkout" method="POST">
                @csrf
                <div class="row align-items-start">
                    <div class="col-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                Billing Details
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="first_name" 
                                            name="first_name" 
                                            placeholder="First Name"
                                            value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->first_name : '' }}" 
                                            required
                                        >
                                    </div>
                                    <div class="col-6">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="last_name" 
                                            name="last_name" 
                                            placeholder="Last Name"
                                            value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->last_name : '' }}"  
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="phone" 
                                            name="phone" 
                                            placeholder="Phone Number"
                                            value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->phone : '' }}" 
                                            required
                                        >
                                    </div>
                                    <div class="col-6">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="address" 
                                            name="address" 
                                            placeholder="Address"
                                            value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->address : '' }}"  
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="city" 
                                            name="city" 
                                            placeholder="City"
                                            value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->city : '' }}" 
                                            required
                                        >
                                    </div>
                                    <div class="col-6">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="zipcode" 
                                            name="zipcode" 
                                            placeholder="Zipcode"
                                            value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->zipcode : '' }}" 
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!Auth::guard('customer')->check())
                            <div class="card mb-4">
                                <div class="card-header">
                                    Account Details
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" required>
                                        </div>
                                        <div class="col-6">
                                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <a href="/customers/login?redirect=checkout">Already have an account? Login.</a> 
                                </div>
                            </div>
                        @endif
                        <div class="card mb-4">
                            <div class="card-header">
                                Credit Card Details
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="cardno" placeholder="Card Number">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="expirydate" placeholder="Expiry Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card">
                            <div class="card-header">
                                Your Order
                            </div>
                            <div class="card-body">
                                @if (count($cartItems))
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 60px;"></th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Price</th>
                                                <th scope="col" style="width: 100px;">Qty</th>
                                                <th scope="col" class="alignright">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cartItems as $item)
                                                <tr>
                                                    <td>
                                                        <img width="50" src="{{ asset('images/'.$item['image']) }}" />
                                                    </td>
                                                    <td style="vertical-align: middle;">{{ $item['title'] }}</td>
                                                    <td style="vertical-align: middle;">${{ $item['price'] }}</td>
                                                    <td style="vertical-align: middle;">{{ $item['qty'] }}</td>
                                                    <td class="alignright" style="vertical-align: middle;">${{ $item['total'] }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="4" class="alignright">Order Total:</th>
                                                <th class="alignright">${{ $cartTotal }}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <h2>Cart is empty</h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 mb-3">
                    @if(Auth::guard('customer')->check())
                        <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->user()->id }}" />
                    @else
                        <input type="hidden" name="customer_id" value="0" />
                    @endif
                    
                    <button class="btn btn-primary btn-lg" type="submit">Place Order</button>
                  </div>
            </form>
        </div>
    </div>
</div>
@endsection
