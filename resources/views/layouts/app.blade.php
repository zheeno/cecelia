<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('subTitle')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!--Navbar -->
        <nav class="mb-1 navbar fixed-top m-0 navbar-expand-lg navbar-light white">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('img/cecelia-logo-black-transparent.png') }}" class="img-reesponsive" style="width: 150px" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link h1-strong" href="/market">Market Place</a>
            </li>
            </ul>
            <ul class="navbar-nav ml-auto nav-flex-icons">
            @Auth()
            <li class="nav-item bg-red-orange">
                <a onClick="navToShoppingCart()" class="nav-link h1-strong waves-effect waves-light white-text">
                    <i class="fa fa-shopping-cart"></i> Shopping Cart
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link h1-strong dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-default"
                aria-labelledby="navbarDropdownMenuLink-333">
                <span class="dropdown-item white">Logged in as {{ Auth::user()->name }}</span>
                    <a class="dropdown-item" href="{{ route('me.orders') }}">Orders</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <form id="logoutForm" method="POST" action="/logout">
                        @csrf
                        <a onClick="logout()" class="dropdown-item">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </form>
                </div>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link h1-strong waves-effect waves-light" href="{{ route('login') }}">
                <i class="fa fa-sign-in"></i> Sign In
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link h1-strong waves-effect waves-light" href="{{ route('register') }}">
                <i class="fa fa-sign-up"></i> Sign Up
                </a>
            </li>
            @endAuth
            </ul>
        </div>
        </nav>
        <!--/.Navbar -->
        <main style="margin-top: 50px">
            @yield('content')
        </main>
        <!-- footer -->
        <footer class="container-fluid grey darken-4">
            <!-- newsletter -->
            <section class="row p-5 bg-red-orange">
                <div class="col-md-8 mx-auto p-3">
                    <h2 class="h2-responsive h-strong white-text">Don&apos;t miss out on mouth-watering offers.<br />
                    Subscribe to our newsletter</h2>
                </div>
                <div class="col-md-4 mx-auto p-3">
                    <form class="row" method="POST" action="./">
                        <div class="col-md-6 p-0 m-0">
                            <input class="form-control" type="email" placeholder="Your e-mail address" name="email" required/>
                        </div>
                        <div class="col-md-3 p-0" style="padding-left:5px !important">
                            <button type="submit" class="btn btn-outline-white btn-md m-0 capitalize">Subscribe</button>
                        </div>
                    </form>
                </div>
            </section>
            <div class="row p-5">
                <div class="col-12 align-center">
                    <img src="{{ asset('img/cecelia-logo-white-transparent.png') }}" class="img-responsive" style="width:120px" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Cities</span>
                    <ul class="list-group">
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Lagos</li>
                    </ul>
                </div>
                
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Food Categories</span>
                    <ul class="list-group">
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Cereals</li>
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Tubers</li>
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Vegetables</li>
                    </ul>
                </div>
                
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Cecelia</span>
                    <ul class="list-group">
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Lagos</li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>
<script>
    function navToShoppingCart(){
        const token = localStorage.getItem('cartToken');
        window.location.href = "/market/checkout?q="+token;
    }

    function logout(){
        localStorage.removeItem("cartToken");
        $('#logoutForm').submit();
    }
</script>
</html>
