<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, user-scalable=no" />

    <title>{{ config('app.name', 'Laravel') }} | @yield('subTitle')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.16c085c5d4.js"></script>

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
            <img src="{{ asset('img/cecelia-logo-black.png') }}" class="img-reesponsive" style="width: 150px" />
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
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle h1-strong" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Categories
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default"
                    aria-labelledby="navbarDropdownMenuLink-333">
                    <?php $categories = \App\Category::orderby('category_name', 'ASC')->get(); ?>
                        @foreach($categories as $category)
                        <a class="dropdown-item h1-strong" href="/market/category/{{ $category->id}}">{{ $category->category_name}}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
            @Auth()
            <li class="nav-item bg-red-orange">
                <a onClick="navToShoppingCart()" class="nav-link waves-effect waves-light white-text h1-strong">
                    <i class="fa fa-shopping-cart"></i> Shopping Cart
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h1-strong" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle" style="font-size:18px;color:#b80514"></i>&nbsp;
                {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-default"
                aria-labelledby="navbarDropdownMenuLink-333">
                    @if(Auth::user()->isAdmin())
                    <a class="dropdown-item h1-strong" href="{{ route('console.dashboard') }}">Console</a>
                    @endif
                    <a class="dropdown-item h1-strong" href="{{ route('me.orders') }}">Orders</a>
                    <form id="logoutForm" method="POST" action="/logout">
                        @csrf
                        <a onClick="logout()" class="dropdown-item h1-strong">
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
        <main style="margin-top: 50px;overflow-x: hidden">
            @yield('content')
        </main>
        <!-- footer -->
        <footer class="container-fluid transparent">
            <!-- recipe for the week -->
            @Auth()
                <?php $recipe = \App\Recipe::orderby('id', 'DESC')->take(1)->get(); ?>
                @if(count($recipe) > 0)
                <section class="row p-0 white shadow-lg m-3">
                    <div class="col-md-4 p-0 has-background-img" style="min-height:200px;background-image:url({{ $recipe[0]->image_url }});"></div>
                    <div class="col-md-8" style="padding: 30px 0px 0px 20px">
                        <h2 class="dark-grey-text h2-responsive h1-strong">Recipe for the Week</h2>
                        <h4 class="h4-responsive h1-strong dark-grey-text">{{ $recipe[0]->title }}</h4>
                        <p class="lead dark-grey-text">{!! $recipe[0]->steps !!}</p>
                    </div>
                </section>
                @endif
            @endAuth
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
            <div class="row p-5" style="background-color: #363435 !important">
                <div class="col-12 align-center">
                    <img src="{{ asset('img/cecelia-logo-black-bg.png') }}" class="img-responsive" style="width:120px" />
                </div>
            </div>
            <div class="row" style="background-color: #363435 !important">
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Cities</span>
                    <ul class="list-group">
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Lagos</li>
                    </ul>
                </div>
                
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Food Categories</span>
                    <ul class="list-group">
                        @foreach($categories as $category)
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px"><a class="white-text" href="/market/category/{{ $category->id}}">{{ $category->category_name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Cecelia</span>
                    <div>
                        <a href="https://www.facebook.com/cecelia.foods" target="_blank" class="btn transparent orange-text shadow-none"><span class="fab fa-facebook fa-3x"></span></a>
                        <a href="https://twitter.com/ceceliafood?s=08" target="_blank" class="btn transparent orange-text shadow-none"><span class="fab fa-twitter-square fa-3x"></span></a>
                        <a href="https://www.instagram.com/ceceliafoods?r=nametag" target="_blank" class="btn transparent orange-text shadow-none"><span class="fab fa-instagram fa-3x"></span></a>
                    </div>
                    <!-- <ul class="list-group">
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Lagos</li>
                    </ul> -->
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
