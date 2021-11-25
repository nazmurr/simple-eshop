@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="container mt-5">
  <div class="row align-items-start row-cols-3 gy-5">
    <div class="col">
      <div class="card">
        <img src="https://cdn.mos.cms.futurecdn.net/6t8Zh249QiFmVnkQdCCtHK.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Product title</h5>
          <p class="card-text">product content</p>
          <div style="text-align: center;">
            <a href="#" class="btn btn-primary">View Product</a>
            <a href="#" class="btn btn-primary">Add to Cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
