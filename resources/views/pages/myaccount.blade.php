@extends('layouts.app')
@section('title', 'My Account')
@section('content')
<style>
    .alignright {
        text-align: right;
    }
</style>
<div class="container mt-5">
    <div class="row align-items-start">
        
        <div class="col-12">
            <h1 class="mb-3">My Account</h1>
            <h3 class="mb-3">Order History</h3>
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
                    <tr>
                        <td>200</td>
                        <td>$20.00</td>
                        <td>Pending</td>
                        <td>July 30, 2020 09:30 AM</td>
                        <td class="alignright">
                            <button class="btn btn-primary" type="button">View Order</button>
                        </td>
                    </tr>
                    <tr>
                        <td>200</td>
                        <td>$20.00</td>
                        <td>Pending</td>
                        <td>July 30, 2020 09:30 AM</td>
                        <td class="alignright">
                            <button class="btn btn-primary" type="button">View Order</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
