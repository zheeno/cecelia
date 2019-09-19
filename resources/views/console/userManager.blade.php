@extends('layouts.console')

@section('subTitle') Console | User Manager @endsection

<?php $cur_page = "users"; ?>
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
                <span class="h1-strong">User Manager</span>
            </h4>
            <!-- search bar  -->
            <div class="row m-2 m-md-4">
                <div class="col-md-8 mx-auto shadow-lg">
                    <form class="row" method="GET" action="{{ route('console.categories') }}">
                        <div class="col-7 p-2 p-md-3">
                            <div class="md-form p-0 m-0">
                                <input class="form-control" type="text" name="q" placeholder="Search categories" required />
                            </div>
                        </div>
                        <div class="col-5 p-2 p-md-3 align-center">
                            <button type="submit" class="btn btn-danger bg-red-orange white-text capitalize m-0 p-2" title="Search Categories"><span class="fa fa-search"></span></button>
                            <button type="button" class="btn btn-danger bg-red-orange white-text capitalize m-0 p-2" data-toggle="modal" data-target="#addCatModal" title="Add a new category"><span class="fa fa-plus"></span></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /search bar  -->
            <div class="row">
                <div class="col-12" style="overflow-x: auto">
                    <table class="table table-striped shadow" style="margin-top:40px">
                        <thead class="bg-red-orange p-1">
                            <th class="p-1 bold white-text">Name</th>
                            <th class="p-1 bold white-text">E-mail</th>
                            <th class="p-1 bold white-text">Permission</th>
                            <th class="p-1 bold white-text">Processed Orders</th>
                            <th class="p-1 bold white-text">Pending Orders</th>
                            <th class="p-1 bold white-text">Orders</th>
                        </thead>
                        <tbody>
                            @foreach($params['users'] as $user)
                            <tr class="hoverable" style="cursor: pointer;" onClick="window.location = '/console/users/{{ $user->id }}' ">
                                <td class="p-1">{{ $user->name }}</td>
                                <td class="p-1">{{ $user->email }}</td>
                                <td class="p-1">@if($user->isAdmin()) Administrator @else Customer @endif</td>
                                <td class="p-1">{{ number_format(count($user->orders) - count($user->pendingOrders)) }}</td>
                                <td class="p-1">{{ number_format(count($user->pendingOrders)) }}</td>
                                <td class="p-1">{{ number_format(count($user->orders)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">{{ $params['users']->links() }}</div>
            </div>
        </div>
    </div>
</div>


<!-- add category modal -->
<div class="modal fade" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="addCatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-bottom modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h1-strong w-100" id="addCatModalLabel">
                    Add Category
                </h4>
                <!-- <a class="btn btn-sm transparent no-shadow white-text" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text fa fa-angle-down fa-2x"></span>
                </a> -->
            </div>
            <div class="modal-body pad-bot-50" style="text-align: center !important">
                <form method="POST" action="/console/categories" class="p-md-3">
                    <div class="md-form">
                        @csrf
                        <label class="active">Category Name</label>
                        <input type="text" class="form-control" name="cat_name" required/>
                    </div>
                    <div class="md-form">
                        <label class="active">Description</label>
                        <textarea  class="md-textarea" style="width: 100%" name="desc" required ></textarea>
                    </div>
                    <div class="md-form">
                        <label class="active">Cover Image URL (Optional)</label>
                        <input type="url" class="form-control" name="cover_image" />
                    </div>
                    <div class="align-center">
                        <button class="btn btn-md capitalize bg-red-orange white-text" type="submit">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /add category modal -->
@endsection