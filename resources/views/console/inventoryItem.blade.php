<?php $cur_page = "inventory"; $foodItem = $params['foodItem']; ?>
@extends('layouts.console')

@section('subTitle') Console | Inventory Manager | {{ $foodItem->item_name }} @endsection

@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="row p-3">
                <div class="col-12 p-4">
                    <h4 class="h4-responsive">
                        <a class="dark-grey-text" href="{{ route('console.dashboard') }}">Console</a> >
                        <a class="dark-grey-text" href="{{ route('console.inventory') }}">Inventory Manager</a> >
                        <strong class="h1-strong dark-grey-text">{{ $foodItem->item_name }}</strong>
                    </h4>
                </div>
                @if(session('alert_success'))
                    <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
                @endif
                @if(session('alert_failure'))
                    <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
                @endif
            </div>
            <div class="row pad-tb-50">
                <div class="col-md-10 shadow mx-auto white">
                    <div class="row">
                        <div style="min-height:230px;background-image: url({{ $foodItem->item_image }});background-size: contain !important;background-position: center !important;" class="align-center col-md-3 white p-0 hoverable has-background-img">
                            <!-- holds item image -->
                            @if(strlen($foodItem->item_image) == 0)
                            <span class="grey-text">NO ITEM IMAGE</span>
                            @endif
                        </div>
                        <div class="lighten-4 col-md-9 p-4">
                        <form  method="POST" action="/console/inventory/updateItem">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="h5-responsive h1-strong">Manage Item</h5>
                                    <ul class="list-group">
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span>Item Name: </span>
                                                    @csrf
                                                    <input type="hidden" name="item_id" value="{{ $foodItem->id }}" />
                                                    <input name="item_name" type="text" style="font-size: 18px;font-weight:800" class="p-0 transparent border-0" value="{{ $foodItem->item_name }}" />
                                                </div>
                                            </div>
                                        </li>
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Category: </span>
                                            <select id="cat_id_sel" style="font-size: 18px;font-weight:800" name="cat_id" class="transparent border-0 pad-0" required>
                                                @foreach($params['categeories'] as $cat)
                                                <option value="{{ $cat->id }}" <?php if($foodItem->category_id == $cat->id){ echo "selected"; } ?> >{{ $cat->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Subcategory: </span>
                                            <span id="sub_cat_id_sel">
                                                <select style="font-size: 18px;font-weight:800" name="sub_cat_id" class="transparent border-0 pad-0" required>
                                                    @foreach($foodItem->category->subCategories as $subCat)
                                                    <option value="{{ $subCat->id }}" <?php if($foodItem->sub_category_id == $subCat->id){ echo "selected"; } ?> >{{ $subCat->sub_category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </li>
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Item Image</span>
                                            <input type="text" name="item_image" style="font-size: 18px;font-weight:800" class="p-0 transparent border-0" value="{{ $foodItem->item_image }}" />
                                        </li>
                                    </ul>
                                    @if($foodItem->stock_qty == 0)
                                    <div class="align-center" style="margin-top:20px">
                                        <span class="animated pulse infinite badge badge-danger white-text">OUT OF STOCK</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Unit Measure: </span>
                                            <select style="font-size: 18px;font-weight:800" name="unit_id" class="transparent border-0 pad-0">
                                                @foreach($params['units'] as $unit)
                                                <option value="{{ $unit->id }}" <?php if($foodItem->unit_measure_id == $unit->id){ echo "selected"; } ?> >{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Price: <strong>&#8358;</strong></span>
                                            <input name="item_price" type="text" style="width:50%;font-size: 18px;font-weight:800" class="p-0 transparent border-0" value="{{ number_format($foodItem->price, 2) }}" />
                                        </li>
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Tax (%): </span>
                                            <input type="text" name="item_tax" style="width:50%;font-size: 18px;font-weight:800" class="p-0 transparent border-0" value="{{ number_format(($foodItem->tax * 100), 2) }}" />
                                        </li>
                                        <li class="h5-responsive transparent p-0 list-group-item border-0" style="border-bottom: 1px solid #eee !important">
                                            <span>Stock: <small>({{ $foodItem->unit->name }})</small></span>
                                            <input type="number" name="stock_qty" style="width:50%;font-size: 18px;font-weight:800" class="p-0 transparent border-0" value="{{ number_format($foodItem->stock_qty, 2) }}" />
                                        </li>
                                    </ul>
                                    <div class="col-md-5 mx-auto p-3">
                                        <button type="submit" class="btn btn-danger bg-red-orange white-text capitalize">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-2 p-md-4" style="margin-bottom: 100px">
        <div class="col-md-10 mx-auto p-0">
            <h4 class="h4-responsive h1-strong">Related Orders</h4>
        </div>
        <div class="col-md-10 mx-auto p-0 shadow white"  style="overflow-x: auto">
            <table class="table table-striped ">
                <thead class="bg-red-orange p-1">
                    <th class="p-1 bold white-text">Cart Token</th>
                    <th class="p-1 bold white-text">Customer Name</th>
                    <th class="p-1 bold white-text">Customer Phone</th>
                    <th class="p-1 bold white-text">Quantity</th>
                    <th class="p-1 bold white-text">Price</th>
                    <th class="p-1 bold white-text">Tax</th>
                    <th class="p-1 bold white-text">Total</th>
                    <th class="p-1 bold white-text">Date Placed</th>
                    <th class="p-1 bold white-text">Delivery Status</th>
                </thead>
                <tbody>
                @foreach($foodItem->cartItems as $item)
                    @if($item->order != null)
                    <tr class="hoverable" style="cursor: pointer;" onClick="window.location = '/console/orders/{{ $item->order->id }}'">
                        <td class="p-1">{{ substr($item->order->cart_token,  7, 10) }}</td>
                        <td class="p-1">{{ $item->order->customer_name }}</td>
                        <td class="p-1">{{ $item->order->phone_no }}</td>
                        <td class="p-1">{{ number_format($item->qty) }}</td>
                        <td class="p-1">&#8358;{{ number_format($item->price, 2) }}</td>
                        <td class="p-1">{{ number_format(($item->tax * 100), 2) }}%</td>
                        <td class="p-1">&#8358;{{ number_format($item->total, 2) }}</td>
                        <td class="p-1">{{ $item->created_at }}</td>
                        <td class="p-1">@if($item->order->delivery_status == 0) <span class="badge badge-danger white-text" style="font-size:13px">Pending</span> @else <span class="badge badge-success white-text" style="font-size:13px">Delivered</span> @endif</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#cat_id_sel').on('change', function(e){
        e.preventDefault();
        let cat_id = $(this).val();
        $('#sub_cat_id_sel').html('<span class="fa fa-spinner fa-spin" style="color: #b80514"></span>').load('/console/getSubCat?cat_id='+cat_id, function(){
            console.log("Loaded");
        });
    });
</script>
@endsection