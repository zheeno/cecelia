@extends('layouts.app')

@section('subTitle') Checkout @endSection

@section('content')

    @if($params['cartContent']['is_on_order_list'] == true)
    <div class="container-fluid">
        <div class="row" style="padding-top:100px; padding-bottom:100px">
            <div class="col-md-8 mx-auto align-center p-3">
                <span class="fa fa-exclamation-triangle fa-4x warning-ic"></span>
                <br /><br />
                <p class="lead dark-grey-text">Sorry we were unable to find the items which you added to cart.<br />
                They may have been moved to your order list, kindly click the button below.<br />
                <a class="btn btn-danger bg-red-orange capitalize white-text" href="/me/orders/{{ $params['cartContent']['order_id'] }}">View orders</a> 
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid">
        <form class="row" style="padding-top:20px" method="POST" action="/market/checkout">
            @csrf()
            <div class="col-md-8 mx-auto p-5 white pad-tb-50">
                <div class="row p-3">
                    <div class="col-md-11 mx-auto md-form">
                        <h3 style="color: #424242" class="h1-strong">Pick-up Details</h3>
                    </div>
                    <div class="md-form col-md-5 mx-auto">
                        <label class="active">*Customer Name</label>
                        <input type="hidden" name="cart_token" value="{{ $params['cartToken'] }}" />
                        <input type="text" placeholder="Chris Chuks" class="form-control" name="customer_name" required/>
                    </div>
                    <div class="md-form col-md-5 mx-auto">
                        <label class="active">Customer E-mail</label>
                        <input type="text" placeholder="chris.chuks@mail.com" class="form-control" name="customer_email" />
                    </div>
                </div>

                <div class="row p-3">
                    <div class="md-form col-md-5 mx-auto">
                        <label class="active">*Phone No.</label>
                        <input type="text" placeholder="080XXXXXXXX" class="form-control" name="phone_no" required/>
                    </div>
                    <div class="md-form col-md-5 mx-auto">
                        <label class="active">*Country</label>
                        <input type="text" placeholder="Nigeria" class="form-control" name="country" required/>
                    </div>
                </div>
                
                <div class="row p-3">
                    <div class="md-form col-md-5 mx-auto">
                        <label class="active">*State</label>
                        <input type="text" placeholder="Lagos" class="form-control" name="state" required/>
                    </div>
                    <div class="md-form col-md-5 mx-auto">
                        <label class="active">L.G.A</label>
                        <input type="text" placeholder="Ikorodu" class="form-control" name="lga" />
                    </div>
                </div>
                
                <div class="row p-3">
                    <div class="md-form col-md-11 mx-auto">
                        <label class="active">*Delivery Address</label>
                        <textarea class="md-textarea" style="width:100%" name="address" required ></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mx-auto pad-tb-50 grey lighten-5">
                <!-- holds cart items and other data -->
                @if(count($params['cartContent']['cart']) == 0)
                <div class="pad-tb-100 justify-center" style="text-align:center">
                    <span class="fa fa-info-circle fa-4x grey-text"></span>
                    <p class="grey-text">Your cart is empty</p>
                </div>
                @else
                    <div class="align-center">
                        <h3 style="color: #424242" class="h1-strong">Cart <small>({{ count($params['cartContent']['cart']) }})</small></h3>
                    </div>
                    <ul class="list-group">
                        @foreach($params['cartContent']['cart'] as $item)
                            <div class="list-group-item p-1 transparent" style="border-width: 0; border-bottom: 1px dashed #d7d7d7">
                                <div class="row">
                                    <div class="col-md-8 p-1">
                                        <span class="h1-strong">{{ $item['foodItem']['item_name'] }}</span>
                                        <br />
                                        <span class="grey-text" style="font-size: small">&#8358;{{ $item['itemData']['price'] }} &times; {{ $item['itemData']['qty']." ".$item['unit']['name']."(s)" }}</span>
                                        @if($item['itemData']['tax'] > 0)
                                            <br />
                                            <small class="grey-text">{{ ($item['itemData']['tax'] * 100)."%" }} Tax Inclusive  (&#8358;{{ number_format(($item['itemData']['tax']) * ($item['itemData']['price'] * $item['itemData']['qty'] ), 2) }})</small>
                                        @endif
                                    </div>
                                    <div class="col-md-3 p-0" style="text-align: right">
                                        <strong class="black-text p-0 m-0">&#8358;{{ number_format($item['itemData']['total'], 2)}}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                    <div class="row">
                        <div class="col-12 p-3" style="text-align: right">
                            @if($params['cartContent']['cartData']['tax'] > 0)    
                                <h3 class="h3-responsive m-0">&#8358;{{ number_format($params['cartContent']['cartData']['total'], 2) }}</h3>
                                <small>Total</small>
                                <h3 class="h3-responsive m-0">&#8358;{{ number_format($params['cartContent']['cartData']['tax'], 2) }}</h3>
                                <small>Tax</small>
                            @endif
                            <h2 class="h2-responsive m-0">&#8358;{{ number_format($params['cartContent']['cartData']['subTotal'], 2) }}</h2>
                            <small>Sub total</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="pull-right btn bg-red-orange btn-md capitalize white-text" >Proceed to Payment <span class=" fa fa-credit-card white-ic"></span></button>
                        </div>
                        <div class="col-12">
                            <button type="button" class="pull-right btn btn-md capitalize grey lighten-2" style="color: #333 !important" data-toggle="modal" data-target="#cancelModal" >Cancel <span class="fa fa-times black-ic"></span></button>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-bottom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h1-strong w-100" id="cancelModalLabel">
                        Leave the market place
                    </h4>
                    <!-- <a class="btn btn-sm transparent no-shadow white-text" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text fa fa-angle-down fa-2x"></span>
                    </a> -->
                </div>
                <div class="modal-body pad-bot-50" style="text-align: center !important">
                    <p class="lead">
                        This operation can not be undone.<br />
                        Do you wish to proceed?
                    </p>
                    <form method="POST" onSubmit="localStorage.removeItem('cartToken')" action="/market/leaveMarket">
                        @csrf
                        <input type="hidden" name="cart_token" value="{{ $params['cartContent']['cartData']['token'] }}" />
                            <button type="submit" class="btn bg-red-orange btn-md capitalize white-text" >Proceed <span class="fa fa-check" ></span></button>
                            <button type="button" class="btn btn-md capitalize grey lighten-2" style="color: #333 !important" data-toggle="modal" data-target="#cancelModal" >Cancel <span class="fa fa-times" style="color: #333 !important"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endSection