@extends('layouts.app')

@section('subTitle') My Orders @endSection

@section('content')

    <div class="container pad-tb-50">
        <div class="col-md-11 col-lg-10 mx-auto">
            <h2 class="h1-strong h2-responsive">My Orders</h2>
            @if(session('alert_success'))
                <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
            @endif
            @if(session('alert_failure'))
                <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
            @endif
        </div>

       <div class="col-md-11 col-lg-10 mx-auto">
        @if(count($params['orders']) == 0)
        <div class="pad-tb-100 align-center">
            <span class="fa fa-info-circle fa-4x grey-ic"></span><br /><br />
            <p class="lead grey-text">You currently do not have any orders placed</p>
            <a class="btn btn-outline-red capitalize" href="/market">Go Shopping</a>
        </div>
        @else
            <div class="list-group">
            @foreach($params['orders'] as $order)
                <div class="list-group-item p-3 m-1 shadow" style="@if($order->delivery_status) border-bottom: 3px solid #03b103; @endif">
                    <div class="p-0 row">
                        <div class="col-md-3">
                            <span class="badge black white-text">Token</span><br>
                            <strong>{{ substr($order->cart_token,  7, 10) }}</strong>
                        </div>
                        <div class="col-md-3">
                            <span class="badge black white-text">Date Placed</span><br>
                            <span><time class="timeago" datetime="{{$order->created_at}}" title="Order was placed as at: {{$order->created_at}}"></time></span>
                        </div>
                        <div class="col-md-2">
                            <span class="badge black white-text">No. of Items</span><br>
                            <span>{{ count($order->cartItems) }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="badge black white-text">Total</span><br>
                            <h4 class="@if($order->payment_status) h1-strong @endif h4-responsive">&#8358;{{ number_format($order->order_total, 2) }}</h4>
                        </div>
                        <div class="col-md-1 flex-center justify-content-center">
                            <a href="/me/orders/{{ $order->id }}" class="btn transparent shadow-none"><span class="fa fa-angle-right"></span></a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
       </div>
    </div>
@endSection