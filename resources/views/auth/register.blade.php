@extends('layouts.app')
@section('subTitle')Sign Up @endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5 mx-auto pad-tb-100">
            <h2 class="h2-responsive dark-grey-text">Sign Up</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-8 mx-auto m-0 col-form-label">{{ __('Full Name') }}</label>

                    <div class="col-md-8 md-form mx-auto m-0">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-8 mx-auto m-0 col-form-label">{{ __('E-mail Address') }}</label>

                    <div class="col-md-8 md-form mx-auto m-0">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-8 mx-auto m-0 col-form-label">{{ __('Password') }}</label>

                    <div class="col-md-8 md-form mx-auto m-0">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-8 mx-auto m-0 col-form-label">{{ __('Confirm Password') }}</label>

                    <div class="col-md-8 md-form mx-auto m-0">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-10 mx-auto align-center">
                        <button type="submit" class="btn btn-danger bg-red-orange capitalize white-text">
                            {{ __('Register') }}&nbsp;<span class="fa fa-check-circle"></span>
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-blue white-text capitalize">Already have an account?</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7 mx-auto p-0" style="background-image: url({{ asset('img/66488399394004.jpg') }}); background-position:top; background-size: cover; background-attachment: relative; background-repeat: no-repeat">
            <div class="overlay mask p-5 flex-center" style="width:100%;height:100%">
            <span class="fa fa-smile-beam m-3 fa-6x white-ic"></span>
                <h1 class="h1-responsive white-text" style="font-size: 300%;font-weight:bolder">We&apos;re excited to have you.<br />Hope you enjoy your time here</h1>
            </div>
        </div>
    </div>
</div>
@endsection
