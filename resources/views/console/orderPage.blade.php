@extends('layouts.console')
<?php $cur_page = "orders"; $order = $params['order'] ?>

@section('subTitle') Console | Order & Delivery Manager | {{ substr($order->cart_token,  7, 10) }} @endsection

@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="row p-3">
                <div class="col-12 p-3">
                    <h4 class="h4-responsive">
                    <a class="dark-grey-text" href="{{ route('console.dashboard') }}">Console</a> > 
                    <a class="dark-grey-text" href="{{ route('console.orders') }}">Order &amp; Delivery Manager</a> > 
                    <span class="h1-strong">{{ substr($order->cart_token,  7, 10) }}</span>
                    </h4>
                </div>
                @if(session('alert_success'))
                    <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
                @endif
                @if(session('alert_failure'))
                    <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
                @endif
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom:100px">
        <div class="col-md-8 mx-auto">
            <div class="row pad-tb-50">
               <div class="col-md-6 p-3 white shadow mx-auto">
                   <h4 class="h4-responsive h1-strong">Pick-up Address</h4>
                   <ul class="list-group p-0 transparent">
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
               </div>
               <div class="col-md-5 p-3 mx-auto white shadow">
                   <h4 class="h4-responsive h1-strong">Order Details</h4>
                   <ul class="list-group">
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
               </div>
           </div>
           <div class="row">
               <div class="col-12">
                   <h4 class="h4-responsive h1-strong">Items ({{ number_format(count($params['order']->cartItems)) }})</h4>
               </div>
            @foreach($params['order']->cartItems as $cartItem)
                <div class="col-12 list-group-item p-md-0 m-1 shadow">
                    <div class="row">
                        <div class="col-md-3 pad-tb-50 white has-background-img" style="min-height:230px;background-image: url({{ $cartItem->FoodItem->item_image }});background-size: contain !important;background-position: center !important;"></div>
                        <div class="col-md-9 p-5">
                            <h4 class="h4-responsive m-0 h1-strong">{{ $cartItem->FoodItem->item_name }} <a href="/console/inventory/{{$cartItem->FoodItem->id}} "><span class="fa fa-link"></span></a></h4>
                            <div class="row">
                                <div class="col-md-7">
                                    <span class="dark-grey-text">&#8358;{{ number_format($cartItem->price, 2)." per ". $cartItem->FoodItem->unit->name." X ".$cartItem->qty }}</span>
                                    @if($cartItem->tax > 0)
                                    <br /><span class="dark-grey-text">{{ ($cartItem->tax * 100)."%" }} Tax Inclusive</span>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <h3 class="h3-responsive h1-strong">&#8358;{{ number_format($cartItem->total, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="col-md-3 mx-auto shadow-lg white p-4">
            <!-- handle other operations -->
            <div class="row">
                <div class="col-12">
                    <h5 class="h5-responsive h1-strong">Manage Orders &amp; Deliveries</h5>
                    <strong>Order Placed by</strong>
                    <p>{{ $order->user->name }} <a href="/console/users/{{$order->user_id}} "><span class="fa fa-link"></span></a></p>
                    <strong>Date Placed</strong>
                    <p>{{ $order->created_at }}</p>
                    <strong>Cart Items</strong>
                    <p>{{ number_format(count($order->cartItems)) }}</p>
                    <strong>Payment Status </strong>
                    @if($order->payment_status == 0)
                        <p>No Payment made</p>
                    @else
                        <p>Paid&nbsp;<span class="fa fa-check-circle green-text"></span></p>
                    @endif
                    @if(strlen($order->payment_method) > 0)
                        <strong>Payment Method</strong>
                        <p>{{ $order->payment_method }}</p>
                    @endif
                    <div class="hoverable row toggleDelivery" data-value="{{ $order->delivery_status }}" style="padding-top:10px;padding-bottom:10px;cursor:pointer">
                        <div class="col-8">
                            <strong>Delivery Fufilled</strong>
                        </div>
                        <div class="col-4 align-center">
                            <span class="toggler fa fa-2x @if($order->delivery_status == 0) fa-toggle-off red-text @else fa-toggle-on green-text @endif"></span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('console.orders.updateDelivery') }}">
                        <div class="md-form collapse show delStatCol">
                            <strong>Delivery Status Description</strong>
                            @csrf
                            <input type="hidden" id="del_status" name="del_status" value="{{ $order->delivery_status }}" />
                            <input type="text" class="form-control hideable-input" name="del_stat_desc" value="{{ $order->delivery_status_desc }}" required/>
                            <input type="hidden" name="order_id" value="{{ $order->id }}" />
                        </div>
                        <div class="align-center p-4">
                            <button type="submit" class="btn btn-md capitalize btn-danger bg-red-orange white-text">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        $('.toggleDelivery').bind('click', function(e) {
            e.preventDefault();
            let state = Number($(this).attr('data-value'));
            if(state == 0){
                $(this).attr('data-value', '1');
                $('#del_status').val('1');
                $('.delStatCol').collapse('hide');
                $('.toggler').removeClass('fa-toggle-off red-text').addClass('fa-toggle-on green-text');
                $('.hideable-input').addClass('disabled').attr('disabled', true);
            }else{
                $(this).attr('data-value', '0');
                $('#del_status').val('0');
                $('.delStatCol').collapse('show');
                $('.toggler').addClass('fa-toggle-off red-text').removeClass('fa-toggle-on green-text');
                $('.hideable-input').removeClass('disabled').removeAttr('disabled');
            }
        });
    })();
</script>
@endsection
       