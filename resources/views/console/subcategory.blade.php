@extends('layouts.console')

@section('subTitle') Console | Categories | {{ $params['sub_category']->category->category_name }} | {{ $params['sub_category']->sub_category_name }} @endsection

<?php $cur_page = "categories"; $sub_category = $params["sub_category"]; ?>
@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-10 p-0 mx-auto">
            <div class="row p-0">
                @if(strlen($sub_category->cover_image) > 0)
                <div class="col-12 grey lighten-3 pad-tb-100 has-background-img" style="background-image: url({{ $sub_category->cover_image }})" >
                    <!--  -->
                </div>
                @endif
            </div>
            <div class="row p-3">
                @if(session('alert_success'))
                    <div class="justify-content-center flex-center col-12 alert alert-success align-center"><p>{!! session('alert_success') !!}</p></div>
                @endif
                @if(session('alert_failure'))
                    <div class="justify-content-center flex-center col-12 alert alert-danger align-center"><p>{!! session('alert_failure') !!}</p></div>
                @endif
                <div class="col-12 p-4">
                    <h4 class="h4-responsive dark-grey-text">
                        <a style="text-decoration: none; color: #333 !important" href="{{ route('console.dashboard') }}">Console</a> > <a style="text-decoration: none; color: #333 !important" href="{{ route('console.categories') }}">Categories</a> > <a style="text-decoration: none; color: #333 !important" href="/console/categories/{{ $sub_category->category->id }}">{{ $sub_category->category->category_name }}</a> > <span class="h1-strong">{{ $sub_category->sub_category_name }}</span>
                    </h4>
                    @if(strlen($sub_category->description) > 0)
                        <p><span class="blue-ic fa fa-info-circle"></span>&nbsp; {{ $sub_category->description }}</p>
                    @endif
                    <button class="btn btn-sm bg-red-orange capitalize white-text" data-toggle="modal" data-target="#addFoodModal"><span class="fa fa-plus"></span> New Food Item</button>
                </div>
            </div>
            <div class="row p-3">
                @if(count($sub_category->foodItems) == 0)
                    <div class="col-12 pad-tb-100 align-center">
                        <span class="fa fa-info-circle fa-4x grey-ic"></span>
                        <br /><br />
                        <p class="grey-text">There are currently no food items related to this subcategory</p>
                    </div>
                @else
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
                            @foreach($sub_category->foodItems as $item)
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
                @endif
            </div>
        </div>
        <!-- <div class="col-md-4"></div> -->
   </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="addFoodModal" tabindex="-1" role="dialog" aria-labelledby="delCatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-bottom" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h1-strong w-100" id="delCatModalLabel">
                        New Food Item
                    </h4>
                    <!-- <a class="btn btn-sm transparent no-shadow white-text" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text fa fa-angle-down fa-2x"></span>
                    </a> -->
                </div>
                <div class="modal-body pad-bot-50" style="text-align: center !important">
                    <form method="POST" action="{{ route('console.add.foodItem') }}">
                        @csrf
                        <input type="hidden" name="sub_cat_id" value="{{ $sub_category->id }}" />
                        <div class="md-form">
                            <label class="active">Item Name</label>
                            <input type="text" name="item_name" class="form-control" required />
                        </div>
                        <div class="md-form">
                            <label class="active">Item Image URL</label>
                            <input type="url" name="item_image" class="form-control" required />
                        </div>
                        <div class="md-form">
                            <label class="active">Description</label>
                            <textarea name="item_desc" class="md-textarea" style="width: 100%" required ></textarea>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-5 p-0 mx-auto md-form">
                                <label class="active">Price (&#8358;)</label>
                                <input type="text" name="price" class="form-control" required />
                            </div>
                            <div class="col-md-5 p-0 mx-auto md-form">
                                <label class="active">Tax (%)</label>
                                <input type="text" name="tax" class="form-control" required />
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col-md-5 p-0 mx-auto md-form">
                                <label class="active">Measurement Unit</label>
                                <select name="unit" class="form-control border-0" required >
                                    @foreach($params['units'] as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 p-0 mx-auto md-form">
                                <label class="active">Stock Quantity</label>
                                <input type="text" name="stock" class="form-control" required />
                            </div>
                        </div>
                        <button type="submit" class="btn bg-red-orange btn-md capitalize white-text" >Add Item <span class="fa fa-plus" ></span></button>
                        <button type="button" class="btn btn-md capitalize grey lighten-2" style="color: #333 !important" data-toggle="modal" data-target="#addFoodModal" >Cancel <span class="fa fa-times" style="color: #333 !important"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection