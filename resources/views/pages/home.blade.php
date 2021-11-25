@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container mt-5">
  @if(Session::has('flash_addtocart_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session('flash_addtocart_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  <div class="row align-items-start row-cols-3 gy-5">
    @foreach ($products as $product)
      <div class="col">
        <div class="card">
          <a href="{{ url('/product/'.$product->id) }}">
            <img src="{{ asset('images/'.$product->image) }}" class="card-img-top" alt="product image">
          </a>
          <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
              <h5 class="card-title">
                <a href="{{ url('/product/'.$product->id) }}" style="text-decoration: none; color: inherit;">{{ $product->title }}</a>
              </h5>
              <h6 style="color: green;">${{ number_format($product->price, 2) }}</h6>
            </div>
            <p class="card-text">{{ substr($product->description, 0, 100)."..." }}</p>
            <div style="text-align: center;">
              <a href="{{ url('/product/'.$product->id) }}" class="btn btn-primary">View Product</a>
              <a href="#" class="btn btn-primary addtocart-button" data-id="{{ $product->id }}">Add to Cart</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
<form id="add-to-cart-form" action="/add-to-cart" method="POST" style="display: none;">
  @csrf
  <input type="hidden" value="1" name="product_qty">
  <input type="hidden" id="product_id" name="product_id">
</form>
@push('scripts')
<script>
  $(function() {
    $(".addtocart-button").click(function(e) {
      e.preventDefault();
      var productId = $(this).data('id');
      $("#add-to-cart-form #product_id").val(productId);
      $("#add-to-cart-form").submit();
    });
  });
</script>
@endpush
@endsection
