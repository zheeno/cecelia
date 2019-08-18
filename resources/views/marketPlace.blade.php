@extends('layouts.app')

@section('subTitle') Market Place @endSection

@section('content')

    <div class="container-fluid">
        <div class="row" style="padding-top:20px">
            <div id="index" class="col-md-12 mx-auto p-0 min-height-100">
                <!-- content here will be replaced with react js -->
                <div class="row p-5" style="height: 100%">
                    <div class="col-12 p-5 align-center justify-content-center" style="height: 100%">
                        <img class="img-responsive animated pulse infinite" src="{{ asset('img/cecelia-logo-grey-transparent.png') }}" style="width: 30% " />
                            <p style="color:#d7d7d7">We&apos;re getting everything ready...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endSection