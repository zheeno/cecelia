@extends('layouts.console')

@section('subTitle') Console | User Manager | {{ $params['user']->name }} @endsection

<?php $cur_page = "users"; $user = $params['user']; ?>
@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid pad-tb-50">
    <div class="row">
        @if(session('alert_success'))
            <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
        @endif
        @if(session('alert_failure'))
            <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <h4 class="h4-responsive">
                <a class="dark-grey-text" href="{{ route('console.dashboard') }}">Console</a> >
                <a class="dark-grey-text" href="{{ route('console.userManager') }}">User Manager</a>
                <span class="h1-strong">> {{ $user->name }}</span>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 mx-auto p-4">
            <div class="row shadow white">
                <div class="col-12 bg-red-orange p-5 align-center">
                    <span class="white-text fa-6x">{{ substr($user->name, 0, 1) }}<span>
                </div>
                <div class="col-12">
                    <form method="POST" action="/console/userManager">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                    <ul class="list-group">
                        <li class="list-group-item p-2 border-0">
                            <span class="grey-text">Full name</span><br />
                            <strong style="font-size:18px">{{ $user->name }}</strong>
                        </li>
                        <li class="list-group-item p-2 border-0">
                            <span class="grey-text">E-mail</span><br />
                            <strong style="font-size:18px">{{ $user->email }}</strong>
                        </li>
                        <li class="list-group-item p-2 border-0">
                            <span class="grey-text">Permission</span>
                            <div class="row">
                                <div class="col-8">
                                    <strong style="font-size:18px">@if($user->isAdmin()) Administrator @else Customer @endif</strong>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-sm pull-right m-0 p-2 shadow-none"><span class="fa fa-exchange-alt brick-red-text"></span></button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item p-2 border-0">
                            <span class="grey-text">Account Created</span><br />
                            <strong style="font-size:18px">{{ $user->created_at }}</strong>
                        </li>
                        @if($user->created_at != $user->updated_at)
                        <li class="list-group-item p-2 border-0">
                            <span class="grey-text">Last Modified</span><br />
                            <strong style="font-size:18px">{{ $user->updated_at }}</strong>
                        </li>
                        @endif
                    </ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 mx-auto">
            <h3 class="h3-responsive h1-strong">Orders ({{count($user->orders)}})</h3>
            @if(count($user->orders) == 0)
                <div class="pad-tb-100 align-center">
                    <span class="fa fa-info-circle fa-5x grey-ic"></span>
                    <br /><br />
                    <p class="grey-text lead">The selected user has not placed any orders</p>
                </div>
            @else
                <table class="table table-striped shadow">
                    <thead class="bg-red-orange p-1">
                        <th class="p-1 bold white-text">Cart Token</th>
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
                        @foreach($user->orders as $order)
                            <tr class="hoverable" style="cursor: pointer;" onClick="window.location = '/console/orders/{{ $order->id }}'">
                                <td class="p-1">{{ substr($order->cart_token,  7, 10) }}</td>
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
            @endif
        </div>
    </div>
</div>
@endsection