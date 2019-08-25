@extends('layouts.app')
@section('subTitle')Login @endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5 mx-auto pad-tb-100">
            <h2 class="h2-responsive dark-grey-text">{{ __('Login') }}</h2>
            <form method="POST" action="{{ route('login') }}" style="margin-top:50px">
                @csrf
                <div class="form-group row">
                    <label for="email" class="col-md-8 mx-auto m-0 col-form-label">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-8 mx-auto md-form m-0">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-8 mx-auto m-0 col-form-label">{{ __('Password') }}</label>

                    <div class="col-md-8 mx-auto md-form m-0">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 mx-auto align-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 mx-auto align-center">
                        <button type="submit" class="btn btn-danger bg-red-orange capitalize white-text">
                            {{ __('Login') }}&nbsp;<span class="fa fa-arrow-right"></span>
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-blue white-text capitalize" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7 mx-auto p-0" style="background-image: url({{ asset('img/b3eb42fe0d3c11e996441224a19270ac.jpg') }}); background-position:top; background-size: cover; background-attachment: relative; background-repeat: no-repeat">
            <div class="overlay mask p-5 flex-center" style="width:100%;height:100%">
            <span class="fa fa-smile-beam m-3 fa-6x white-ic"></span>
                <h1 class="h1-responsive white-text" style="font-size: 300%;font-weight:bolder">We&apos;ve really missed you.<br />Thanks for coming back!</h1>
            </div>
        </div>
    </div>
</div>
@endsection
