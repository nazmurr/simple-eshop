@extends('layouts.app')
@section('title', 'My Account')
@section('content')
<style>
    .alignright {
        text-align: right;
    }

    table tr td {
        vertical-align: middle;
    }
</style>
<div class="container mt-5">
    <div class="row align-items-start">
        
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <h1 class="mb-3">My Account</h1>
                </div>
                <div class="col-6" style="text-align: right;">
                    <button class="btn btn-primary" type="button" onclick="event.preventDefault(); document.getElementById('customer_logout_form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>
            <h3 class="mb-3 mt-2">Order History</h3>
            @if($orders->count()) 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    @switch($order->status)
                                        @case("pending")
                                            <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                                            @break
                                        @case("processing")
                                            <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                                            @break
                                        @default
                                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td class="alignright">
                                    <button class="btn btn-primary" type="button" data-id="{{ $order->id }}" onclick="getOrder(this)">View Order</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No orders found</p>
            @endif
        </div>
    </div>
</div>
<form action="{{ route('customerLogout') }}" method="POST" id="customer_logout_form" style="display:none;">
    @csrf
</form>
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalTitle">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="orderModalBody">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
function getOrder(element) {
    var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    orderModal.show();
    var id = $(element).data('id');
    $("#orderModalTitle").html("Order #" + id);
    $("#orderModalBody").html("");
    $.getJSON( "/order/" + id, function( data ) {
        var modalContent = `
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Qty</th>
                    <th scope="col" class="alignright">Total</th>
                </tr>
            </thead>
            <tbody>`;

        data.products.forEach(product => {
            modalContent += `
            <tr>
                <td>
                    <img width="100" src="/images/${product.image}" />
                </td>
                <td style="vertical-align: middle;">${product.title}</td>
                <td style="vertical-align: middle;">${product.price}</td>
                <td style="vertical-align: middle;">${product.qty}</td>
                <td class="alignright" style="vertical-align: middle;">${product.total}</td>
            </tr>`;
        });
                
        modalContent += "</tbody>";
        $("#orderModalBody").html(modalContent);
    });
}
</script>
@endpush
@endsection
