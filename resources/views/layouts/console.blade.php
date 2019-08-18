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
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        <!--Navbar -->
        @yield('navBar')
        <!--/.Navbar -->
        <main style="margin-top: 50px">
            @yield('content')
        </main>
        <!-- footer -->
        <footer class="container-fluid grey darken-4">
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
        <!-- unit measurement modal -->
        <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-bottom modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h1-strong w-100" id="unitModalLabel">
                            Unit Measurements
                        </h4>
                        <!-- <a class="btn btn-sm transparent no-shadow white-text" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text fa fa-angle-down fa-2x"></span>
                        </a> -->
                    </div>
                    <div class="modal-body pad-bot-50" style="text-align: center !important">
                        <form method="POST" action="{{ route('console.newMeasureUnit') }}">
                            <div class="row">
                                <div class="col-md-5 mx-auto md-form">
                                    <label class="active">Unit Name</label>
                                    @csrf
                                    <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="e.g Bags" required />
                                </div>
                                <div class="col-md-3 mx-auto flex-center">
                                    <button type="submit" class="btn btn-danger bg-red-orange capitalize white-text"><span class="fa fa-plus"></span>&nbsp;Add Unit</button> 
                                </div>
                            </div>
                        </form>
                        <div class="p-2">
                            <?php $units = \App\UnitMeasure::orderby('name', 'ASC')->get(); ?>
                            @foreach($units as $unit)
                            <div class="row hoverable m-2" style="border-bottom:1px solid #d7d7d7">
                                <div class="col-md-7 p-3" style="text-align: left;">
                                    <h4 class="h4-responsive m-0" style="text-align: left;">{{ $unit->name }}</h4>
                                    <span class="grey-text m-0" style="text-align: left;">
                                        <?php $numItems = count($unit->foodItems); $count = 1; ?>
                                        @foreach($unit->foodItems as $food) &nbsp;<a style="text-decoration:none" href="/console/inventory/{{ $food->id }}">{{ $food->item_name }}</a> @if($numItems > $count) &nbsp;&middot; @endif <?php $count++ ?> @endforeach
                                    </span>
                                </div>
                                <div class="col-md-5 grey lighten-4 p-3">
                                    <span class="h4-responsive dark-grey-text"><span class="icon-food"></span>
                                    &nbsp;&middot;&nbsp;{{ number_format(count($unit->foodItems)) }}</span>         
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function logout(){
        localStorage.removeItem("cartToken");
        $('#logoutForm').submit();
    }
</script>
</html>