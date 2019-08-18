@extends('layouts.console')

@section('subTitle') Console | Categories | {{ $params['category']->category_name }} @endsection

<?php $cur_page = "categories"; $category = $params["category"]; ?>
@section('navBar') @include('/console/navBar') @endsection

@section('content')
<div class="container-fluid">
    <div class="row p-0">
        <div class="col-md-8 p-0">
            <div class="row p-0">
                @if(strlen($category->cover_image) > 0)
                <div class="col-12 grey lighten-3 pad-tb-100 has-background-img" style="background-image: url({{ $params['category']->cover_image }})" >
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
                    <h5 class="h5-responsive dark-grey-text">
                        <a style="text-decoration: none; color: #333 !important" href="{{ route('console.dashboard') }}">Console</a> > <a style="text-decoration: none; color: #333 !important" href="{{ route('console.categories') }}">Categories</a> > <strong>{{ $category->category_name }}</strong>
                    </h5>
                    @if(strlen($category->description) > 0)
                        <p><span class="blue-ic fa fa-info-circle"></span>&nbsp; {{ $category->description }}</p>
                    @endif
                </div>
            </div>
            <div class="row p-3">
                <div class="col-md-3 mx-auto shadow-sm p-2 align-center">
                    <h1 class="h1-responsive">{{ number_format(count($category->subCategories)) }}</h1>
                    <p>Sub Categories</p>
                </div>
                <div class="col-md-3 mx-auto shadow-sm p-2 align-center">
                    <h1 class="h1-responsive">{{ number_format(count($category->foodItems)) }}</h1>
                    <p>Food Items</p>
                </div>
            </div>
            <div class="row p-3">
                <div class="col-md-5">
                    <h4 class="h1-strong h4-responsive">Add Sub-category</h4>
                    <form method="POST" action="/console/subCategories" class="p-md-3">
                        <div class="md-form">
                            @csrf
                            <label class="active">Sub-category Name</label>
                            <input type="hidden" name="cat_id" value="{{ $category->id }}" />
                            <input type="text" class="form-control" name="sub_cat_name" required/>
                        </div>
                        <div class="md-form">
                            <label class="active">Description</label>
                            <textarea  class="md-textarea" style="width: 100%" name="desc"  required ></textarea>
                        </div>
                        <div class="md-form">
                            <label class="active">Cover Image URL (Optional)</label>
                            <input type="url" class="form-control" name="cover_image" />
                        </div>
                        <div class="align-center">
                            <button class="btn btn-md capitalize bg-red-orange white-text" type="submit">Create Sub-category</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7">
                    <h4 class="h1-strong h4-responsive">Sub-categories</h4>
                    @if(count($category->subCategories) == 0)
                        <div class="pad-tb-50 align-center">
                            <span class="fa fa-info-circle fa-4x grey-ic"></span>
                            <br /><br />
                            <p class="grey-text">There are no sub-categories associated with this category</p>
                        </div>
                    @else
                        <table class="table table-striped">
                            <tbody>
                                @foreach($category->subCategories as $subCat)
                                    <tr class="hoverable">
                                        <td class="p-2"><strong>{{ $subCat->sub_category_name }} ({{ number_format(count($subCat->foodItems)) }})</strong></td>
                                        <td class="p-2" style="text-align:right"><a href="/console/categories/{{ $category->category_name }}/{{ $subCat->id }}" class="btn btn-link btn-sm shadow-none m-0"><span class="fa fa-arrow-right"></span></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4 p-5">
            <h4 class="h4-responsive h1-strong">Edit Category</h4>
            <form method="POST" action="/console/updateCategory" class="p-md-3">
                <div class="md-form">
                    @csrf
                    <label class="active">Category Name</label>
                    <input type="hidden" name="cat_id" value="{{ $category->id }}" />
                    <input type="text" class="form-control" name="cat_name" value="{{ $category->category_name }}" required/>
                </div>
                <div class="md-form">
                    <label class="active">Description</label>
                    <textarea  class="md-textarea" style="width: 100%" name="desc"  required >{{ $category->description }}</textarea>
                </div>
                <div class="md-form">
                    <label class="active">Cover Image URL (Optional)</label>
                    <input type="url" class="form-control" name="cover_image" value="{{ $category->cover_image }}" />
                </div>
                <div class="align-center">
                    <button class="btn btn-md capitalize bg-red-orange white-text" type="button" data-toggle="modal" data-target="#delCatModal">Delete</button>
                    <button class="btn btn-md capitalize grey lighten-3 dark-grey-text" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="delCatModal" tabindex="-1" role="dialog" aria-labelledby="delCatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-bottom" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h1-strong w-100" id="delCatModalLabel">
                        Delete Category
                    </h4>
                    <!-- <a class="btn btn-sm transparent no-shadow white-text" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text fa fa-angle-down fa-2x"></span>
                    </a> -->
                </div>
                <div class="modal-body pad-bot-50" style="text-align: center !important">
                    <p class="lead">
                        Deleting this category will permanently remove all related data.&nbsp;
                        Kindly note that this operation can not be undone.<br />
                        Do you wish to proceed?
                    </p>
                    <form method="POST" action="{{ route('console.delete.category') }}">
                        @csrf
                        <input type="hidden" name="cat_id" value="{{ $category->id }}" />
                        <button type="submit" class="btn bg-red-orange btn-md capitalize white-text" >Proceed <span class="fa fa-check" ></span></button>
                        <button type="button" class="btn btn-md capitalize grey lighten-2" style="color: #333 !important" data-toggle="modal" data-target="#delCatModal" >Cancel <span class="fa fa-times" style="color: #333 !important"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection