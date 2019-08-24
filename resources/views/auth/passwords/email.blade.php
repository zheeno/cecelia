@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5 mx-auto pad-tb-100">
            <h2 class="h2-responsive dark-grey-text">{{ __('Reset Password') }}</h2><br /><br />
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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

                <div class="form-group row mb-0">
                    <div class="col-md-6 mx-auto align-center">
                        <button type="submit" class="btn btn-danger bg-red-orange capitalize white-text">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7 mx-auto p-0" style="background-image: url({{ asset('img/66488399394004.jpg') }}); background-position:top; background-size: cover; background-attachment: relative; background-repeat: no-repeat">
            <div class="overlay mask p-5 flex-center" style="width:100%;height:100%">
            <span class="fa fa-smile-beam m-3 fa-6x white-ic"></span>
                <h1 class="h1-responsive white-text" style="font-size: 300%;font-weight:bolder">We&apos;re here for you.<br />Let&apos;s help you gain access to your account</h1>
            </div>
        </div>
    </div>
</div>
@endsection
