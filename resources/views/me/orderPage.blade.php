@extends('layouts.app')

@section('subTitle') My Orders | {{ substr($params["order"]->cart_token,  7, 10) }} @endSection

@section('content')

    <div class="container pad-tb-50">
        <div class="col-md-11 col-lg-10 mx-auto">
            <h2 class="h2-responsive"><a href="{{ route('me.orders') }}" class="grey-text" style="text-decoration: none">My Orders</a> | <span class="h1-strong">{{ substr($params["order"]->cart_token,  7, 10) }}</span></h2>
        
            @if(session('alert_success'))
                <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
                <script>localStorage.removeItem("cartToken")</script>
            @endif
            @if(session('alert_failure'))
                <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
                <script>localStorage.removeItem("cartToken")</script>
            @endif
        </div>

       <div class="col-md-11 col-lg-10 mx-auto list-group">
           <div class="row pad-tb-50">
               <div class="col-md-6 p-0 white shadow mx-auto">
                   <h4 class="h4-responsive h1-strong m-3">Pick-up Details</h4>
                   <ul class="list-group transparent p-2" style="margin-bottom:80px !important">
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Name</small><br />
                           <span class="dark-grey-text">{{ $params['order']->customer_name }}</span>
                        </li>
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">E-mail</small><br />
                           <span class="dark-grey-text">{{ $params['order']->customer_email }}</span>
                        </li>
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Phone</small><br />
                           <span class="dark-grey-text">{{ $params['order']->phone_no}}</span>
                        </li>
                        @if($params['order']->country != null)
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Country</small><br />
                           <span class="dark-grey-text">{{ $params['order']->country }}</span>
                        </li>
                        @endif
                        @if($params['order']->state != null)
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">State</small><br />
                           <span class="dark-grey-text">{{ $params['order']->state }}</span>
                        </li>
                        @endif
                        @if($params['order']->lga != null)
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">L.G.A</small><br />
                           <span class="dark-grey-text">{{ $params['order']->lga }}</span>
                        </li>
                        @endif
                        @if($params['order']->address != null)
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Address</small><br />
                           <span class="dark-grey-text">{{ $params['order']->address }}</span>
                        </li>
                        @endif
                    </ul>
                    @if($params['order']->delivery_status == 0)
                    <div class="orange darken-4 p-2" style="bottom: 0px;position: absolute;width: 100%;"><span class="white-text">Delivery Pending</span></div>
                    @else
                    <div class="green p-2" style="bottom: 0px;position: absolute;width: 100%;"><span class="white-text">@if(count($params['cartItems']) > 1) {{"Items"}} @else {{ "Item" }} @endif Delivered</span></div>
                    @endif
               </div>
               <div class="col-md-5 mx-auto white shadow p-0">
                   <h4 class="h4-responsive h1-strong m-3">Order Details</h4>
                   <ul class="list-group p-2" style="margin-bottom:80px !important">
                       <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Delivery Status</small><br />
                           <span class="dark-grey-text">
                            @if($params['order']->delivery_status)
                                <span><span class="fa fa-check-circle green-ic"></span>&nbsp;Delivered</span>
                                 @else 
                                 <span><span class="fa fa-clock orange-ic"></span>&nbsp;{{ $params['order']->delivery_status_desc }}<span> 
                            @endif
                            </span>
                        </li>
                        <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Delivery Method</small><br />
                           <span class="dark-grey-text">{{ $params['order']->delivery_method }}</span>
                        </li>
                        <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Total</small><br />
                           <span class="dark-grey-text">&#8358;{{ number_format ($params['order']->cart_total, 2) }}</span>
                        </li>
                        <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Shipping Fee</small><br />
                           <span class="dark-grey-text">&#8358;{{ number_format ($params['order']->shipping_fee, 2) }}</span>
                        </li>
                        <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Discount</small><br />
                           <span class="dark-grey-text">&#8358;{{ number_format ($params['order']->discount, 2) }}</span>
                        </li>
                        <li class="list-group-item border-0 transparent p-0">
                           <small class="grey-text">Sub Total</small><br />
                           <span class="h4-responsive h1-strong dark-grey-text">&#8358;{{ number_format ($params['order']->order_total, 2) }}</span>
                        </li>
                    </ul>
                    <br />
                    @if($params['order']->payment_status == 0)
                    <div class="red darken-4 p-2" style="bottom: 0px;position: absolute;width: 100%;">
                        <form method="POST" action="/market/initRepay">
                            <span class="white-text">Payment Pending</span>
                            {{ csrf_field()}}
                            <input type="hidden" name="order_id" value="{{ $params['order']->id }}" />
                            <button type="submit" class="btn btn-sm btn-white m-0 p-1" style="float:right">Pay</button>
                        </form>
                    </div>
                    @else
                    <div class="green p-2" style="bottom: 0px;position: absolute;width: 100%;"><span class="white-text">Payment Received</span></div>
                    @endif
               </div>
           </div>
           <div class="row">
               <div class="col-12">
                   <h4 class="h4-responsive h1-strong">Items ({{ number_format(count($params['cartItems'])) }})</h4>
               </div>
            @foreach($params['cartItems'] as $cartItem)
                <div class="col-12 list-group-item p-md-0 m-1 shadow">
                    <div class="row">
                        <div class="col-md-3 pad-tb-50 grey lighten-2 has-background-img" style="background-image: url({{ $cartItem->FoodItem->item_image }})"></div>
                        <div class="col-md-9 p-1">
                            <h4 class="h4-responsive m-0 h1-strong">{{ $cartItem->FoodItem->item_name }}</h4>
                            <div class="row">
                                <div class="col-md-7">
                                    <span class="dark-grey-text">&#8358;{{ number_format($cartItem->price, 2)." per ". $cartItem->FoodItem->unit->name." X ".$cartItem->qty }}</span>
                                    @if($cartItem->tax > 0)
                                    <br /><span class="dark-grey-text">{{ ($cartItem->tax * 100)."%" }} Tax Inclusive</span>
                                    @endif
                                </div>
                                <div class="col-md-5 justify-content-center flex-center">
                                    <h3 class="h3-responsive h1-strong">&#8358;{{ number_format($cartItem->total, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
       </div>
    </div>
@endSection