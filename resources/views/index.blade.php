@extends('layouts.app')

@section('subTitle')
Home
@endSection

@section('content')
<div class="container-fluid">
    <div class="row no-pad hero-container view" >
        <div class="col-12 hero no-pad">
            <div class="overlay mask row m-0">
                <div class="col-md-8 m-0">
                    <h1 class="white-text animated fadeInLeft" style="font-size: 300%">Get quality food items delivered to your doorstep</h1>    
                    <h3 class="white-text h3-responsive" style="">You never have to worry about the hazzle of visiting the market</h3>
                </div>
            </div>
            <!-- some content here -->
        </div>
    </div>
    <div class="row p-3">
        <div class="col-md-8 mx-auto p-5 align-center">
            <h1 class="h1-responsive" style="font-weight: 900;font-family: cursive;">Take care of your body. It's the only place you have to live.</h1>
            <p class="lead">-Jim Rohn</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 left-sided-panel"></div>
        <div class="col-md-6 pad-tb-100" style="padding-left:20px; padding-right:20px">
            <h1 class="h1-strong">Thinking of going to the market?<br />Think again.</h1>
            <p class="lead">Buying food items has never been easy, but with Cecelia,
                you have the entire market at your finger tips. You never have to worry about
                the stress of going to the market anymore.
            </p>
            <div style="text-align:center" style="margin-top:30px">
                <h2 class="h2-responsive h1-strong">
                    We bring the market to you!
                </h2>
                <a href="/market" class="white-text btn btn-orange capitalize"><span class="fa fa-shopping-cart white-ic"></span>&nbsp;Start Shopping</a>
            </div>
        </div>
        <div class="col-md-3 right-sided-panel" style="background-color: #f2f6f7"></div>
    </div>
    <div class="row pad-tb-100">
        <div class="col-md-4 mx-auto">
            <div class="card border-0 transparent">
                <div class="card-body p-2 align-center transparent">
                    <span class="fa fa-4x fa-shopping-cart" style="color: #f99602" ></span>
                    <p class="lead h1-strong m-0" style="margin-top: 15px !important">Choose food Items</p>
                    <span>What would you love to buy?</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mx-auto">
            <div class="card border-0 transparent">
                <div class="card-body p-2 align-center transparent">
                    <span class="fa fa-4x fa-map-marked-alt" style="color: #f00005" ></span>
                    <p class="lead h1-strong m-0" style="margin-top: 15px !important">Set Delivery Location</p>
                    <span>Where would you want us to go?</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mx-auto">
            <div class="card border-0 transparent">
                <div class="card-body p-2 align-center transparent">
                    <span class="fa fa-4x fa-truck-loading" style="color: #578e05" ></span>
                    <p class="lead h1-strong m-0" style="margin-top: 15px !important">Receive it at your doorstep</p>
                    <span>We bring them to you</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection