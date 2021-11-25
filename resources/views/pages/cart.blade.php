@extends('layouts.app')
@section('title', 'Cart')
@section('content')
<style>
    .alignright {
        text-align: right;
    }
</style>
<div class="container mt-5">
    <div class="row align-items-start">
        
        <div class="col-12">
            <h1 class="mb-3">Cart</h1>
            @if (count($cartItems))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 50px;"></th>
                            <th scope="col" style="width: 150px;"></th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col" style="width: 100px;">Qty</th>
                            <th scope="col" class="alignright">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td style="vertical-align: middle;">
                                    <a href="#" data-id="{{ $item['id'] }}" class="removefromcart-button" style="font-size: 20px;">
                                        <i class="far fa-times-circle"></i>
                                    </a>
                                </td>
                                <td>
                                    <img width="100" src="{{ asset('images/'.$item['image']) }}" />
                                </td>
                                <td style="vertical-align: middle;">{{ $item['title'] }}</td>
                                <td style="vertical-align: middle;">${{ $item['price'] }}</td>
                                <td style="vertical-align: middle;">{{ $item['qty'] }}</td>
                                <td class="alignright" style="vertical-align: middle;">${{ $item['total'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="5" class="alignright">Net Total:</th>
                            <th class="alignright">${{ $cartTotal }}</th>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: right;">
                    <button class="btn btn-primary" type="button" onclick="window.location.href='/checkout'">Proceed to Checkout</button>
                </div>
            @else
                <h2>Cart is empty</h2>
            @endif
        </div>
    </div>
</div>
<form id="remove-from-cart-form" action="/remove-from-cart" method="POST" style="display: none;">
    @csrf
    <input type="hidden" id="product_id" name="product_id">
</form>
@push('scripts')
<script>
$(function() {
    $(".removefromcart-button").click(function(e) {
        e.preventDefault();
        var productId = $(this).data('id');
        $("#remove-from-cart-form #product_id").val(productId);
        $("#remove-from-cart-form").submit();
    });
});
</script>
@endpush
@endsection
