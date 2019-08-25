@extends('layouts.console')

@section('subTitle') Console | Inventory Manager @endsection

<?php $cur_page = "inventory"; ?>
@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="row p-3">
                <div class="col-12 p-4">
                    <h4 class="h4-responsive">
                        <a class="dark-grey-text" href="{{ route('console.dashboard') }}">Console</a> >
                        <span class="h1-strong">Inventory Manager</span>
                    </h4>
                </div>
                @if(session('alert_success'))
                    <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
                @endif
                @if(session('alert_failure'))
                    <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
                @endif
            </div>
            <!-- search bar  -->
            <div class="row m-2 m-md-4">
                <div class="col-md-8 mx-auto shadow-lg">
                    <form class="row" method="GET" action="{{ route('console.inventory') }}">
                        <div class="col-9 p-2 p-md-3">
                            <div class="md-form p-0 m-0">
                                <input class="form-control" type="text" name="q" placeholder="Search through your inventory" required />
                            </div>
                        </div>
                        <div class="col-3 p-2 p-md-3 align-center">
                            <button type="submit" class="btn btn-danger bg-red-orange white-text capitalize" title="Search Inventory"><span class="fa fa-search"></span></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /search bar  -->

            <div class="row" style="margin-top:50px">
                <div class="col-12" style="padding-bottom: 150px;overflow-x: auto">
                    <table class="table table-striped shadow">
                        <thead class="bg-red-orange p-1">
                            <th class="p-1 bold white-text">S/N</th>
                            <th class="p-1 bold white-text">Food Item Name</th>
                            <th class="p-1 bold white-text">Category</th>
                            <th class="p-1 bold white-text">Sub Category</th>
                            <th class="p-1 bold white-text">Unit Measure</th>
                            <th class="p-1 bold white-text">Price</th>
                            <th class="p-1 bold white-text">Tax (%)</th>
                            <th class="p-1 bold white-text">Stock</th>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            @foreach($params['foodItems'] as $item)
                            <tr class="hoverable" style="cursor: pointer;" onClick="window.location = '/console/inventory/{{ $item->id }}' ">
                                <td class="p-1">{{ $count }}</td>
                                <td class="p-1">{{ $item->item_name }}</td>
                                <td class="p-1">{{ $item->category->category_name }}</td>
                                <td class="p-1">@if($item->subcategory != null) {{ $item->subcategory->sub_category_name }} @endif</td>
                                <td class="p-1">@if($item->unit != null) {{ $item->unit->name }} @endif</td>
                                <td class="p-1">&#8358;{{ number_format($item->price, 2) }}</td>
                                <td class="p-1">{{ number_format(($item->tax * 100), 2)."%" }}</td>
                                <td class="p-1">{{ $item->stock_qty }}</td>
                            </tr>
                            <?php $count++ ?>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $params['foodItems']->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection