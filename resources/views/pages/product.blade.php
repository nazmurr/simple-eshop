@extends('layouts.app')
@section('title', $product->title)
@section('content')
<div class="container mt-5">
    @if(Session::has('flash_addtocart_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session('flash_addtocart_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row align-items-start gy-5">
        <div class="col-5">
            <img src="{{ asset('images/'.$product->image) }}" class="img-fluid" alt="image">
        </div>
        <div class="col-7">
            <h1 class="mb-3">{{ $product->title }}</h1>
            <div class="stars stars-example-css mb-3">
                <select id="example-css" name="rating" autocomplete="off">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <form action="/add-to-cart" method="POST">
                @csrf
                <div class="row">
                    <h5 style='color: green;'>${{ number_format($product->price, 2) }}</h5>
                    <label for="staticEmail" class="col-sm-1 col-form-label">Qty</label>
                    <div class="col-sm-2">
                        <input type="number" min="1" class="form-control" id="staticEmail" value="1" name="product_qty">
                    </div>
                </div>
                <div class="d-grid gap-2 col-4 mt-4">
                    <button class="btn btn-primary" type="submit">Add to Cart</button>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            {{ $product->description }}
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#example-css').barrating({
            theme: 'css-stars',
            initialRating: '{{ $product->rating }}',
            onSelect:function(value, text, event) {
                var fd = new FormData();    
                fd.append( 'rating', value );
                fd.append( 'product_id', '{{ $product->id }}' );

                $.ajax({
                    url: '/rating',
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    headers: {            
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')        
                    },   
                    success: function(data) {
                        //console.log(data);
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
