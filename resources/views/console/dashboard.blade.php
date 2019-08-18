@extends('layouts.console')

@section('subTitle') Console | Dashboard @endsection

<?php $cur_page = "dashboard"; ?>
@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid pad-tb-50">
    <div class="row">
        <div class="col-12">
            <h3 class="h3-responsive h1-strong">Dashboard</h3>
        </div>
    </div>
    <div class="row p-md-3">
        <div class="col-md-3 mx-auto card p-0" >
            <div class="card-body p-md-5 align-center">
                <h2 class="h1-strong black-text">{{ number_format(count($params['users']), 0) }}</h2>
            </div>
            <div class="card-footer bg-red-orange border-0">
                <span class=" white-text">Users</span>
            </div>
        </div>
        <div class="col-md-3 mx-auto card p-0" >
            <div class="card-body p-md-5 align-center">
                <h2 class="h1-strong black-text">{{ number_format(count($params['categories']), 0) }}</h2>
            </div>
            <div class="card-footer bg-red-orange border-0">
                <span class=" white-text">Categories</span>
                <a class="btn btn-link p-1 m-0 btn-sm" href="{{ route('console.categories') }}" style="float: right"><span class="fa fa-arrow-right white-text"></span></a>
            </div>
        </div>
        <div class="col-md-3 mx-auto card p-0" >
            <div class="card-body p-md-5 align-center">
                <h2 class="h1-strong black-text">{{ number_format(count($params['categories']), 0) }}</h2>
            </div>
            <div class="card-footer bg-red-orange border-0">
                <span class=" white-text">Sub Categories</span>
            </div>
        </div>
    </div>
    <div class="row p-md-3">
        <div class="col-md-auto mx-auto card p-0 flex-center justify-content-center" >
            <div class="card-body p-md-5 align-center">
                <h2 class="h1-strong black-text">{{ number_format(count($params['foodItems']), 0) }}</h2>
            </div>
            <div class="card-footer bg-red-orange border-0">
                <span class=" white-text">Food Items</span>
            </div>
        </div>
        <div class="col-md-6 mx-auto card p-0" >
            <div class="card-body p-md-5 align-center">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h1-strong black-text">{{ number_format($params['orders']['all'], 0) }}</h2>
                        <span class="black-test">All Orders</span>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="h1-strong black-text">{{ number_format($params['orders']['pending'], 0) }}</h2>
                                <span class="black-test">Pending Orders</span>
                            </div>
                            <div class="col-12">
                                <h4 class="h1-strong black-text">{{ number_format($params['orders']['processed'], 0) }}</h2>
                                <span class="black-test">Processed Orders</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-red-orange border-0">
                <span class=" white-text">Orders</span>
            </div>
        </div>
    </div>
</div>
@endsection
