@extends('layouts.console')

@section('subTitle') Console | Order & Delivery Manager @endsection

<?php $cur_page = "orders"; ?>
@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="row p-3">
                <div class="col-12 p-3">
                    <h4 class="h4-responsive">
                        <a class="dark-grey-text" href="{{ route('console.dashboard') }}">Console</a> > 
                        <span class="h1-strong">Order &amp; Delivery Manager</span>
                    </h4>
                </div>
                @if(session('alert_success'))
                    <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
                @endif
                @if(session('alert_failure'))
                    <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
                @endif
            </div>
            <div class="row">
                <div class="col-12" style="padding-bottom: 100px">
                    @if(count($params['orders']) == 0)
                        <div class="pad-tb-100 align-center">
                            <span class="fa fa-info-circle fa-5x grey-ic"></span>
                            <br /><br />
                            <p class="grey-text lead">There are no orders at the moment</p>
                        </div>
                    @else
                        <table class="table table-striped">
                            <thead class="bg-red-orange p-1">
                                <th class="p-1 bold white-text">Cart Token</th>
                                <th class="p-1 bold white-text">Customer Name</th>
                                <th class="p-1 bold white-text">Customer Phone</th>
                                <th class="p-1 bold white-text">Location</th>
                                <th class="p-1 bold white-text">No. Items</th>
                                <th class="p-1 bold white-text">Total</th>
                                <th class="p-1 bold white-text">Shipping Fee</th>
                                <th class="p-1 bold white-text">Discount</th>
                                <th class="p-1 bold white-text">Sub Total</th>
                                <th class="p-1 bold white-text">Payment Status</th>
                                <th class="p-1 bold white-text">Delivery Status</th>
                            </thead>
                            <tbody>
                                @foreach($params['orders'] as $order)
                                    <tr class="hoverable" style="cursor: pointer;" onClick="window.location = '/console/orders/{{ $order->id }}'">
                                        <td class="p-1">{{ substr($order->cart_token,  7, 10) }}</td>
                                        <td class="p-1">{{ $order->customer_name }}</td>
                                        <td class="p-1">{{ $order->phone_no }}</td>
                                        <td class="p-1">{{ $order->address }}</td>
                                        <td class="p-1">{{ number_format(count($order->cartItems)) }}</td>
                                        <td class="p-1">&#8358;{{ number_format($order->cart_total, 2) }}</td>
                                        <td class="p-1">&#8358;{{ number_format($order->shipping_fee, 2) }}</td>
                                        <td class="p-1">&#8358;{{ number_format($order->discount, 2) }}</td>
                                        <td class="p-1">&#8358;{{ number_format($order->order_total, 2) }}</td>
                                        <td class="p-1">@if($order->payment_status == 0) <span class="badge badge-danger white-text" style="font-size:13px">Pending</span> @else <span class="badge badge-success white-text" style="font-size:13px">Paid</span> @endif</td>
                                        <td class="p-1">@if($order->delivery_status == 0) <span class="badge badge-danger white-text" style="font-size:13px">Pending</span> @else <span class="badge badge-success white-text" style="font-size:13px">Delivered</span> @endif</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $params['orders']->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection