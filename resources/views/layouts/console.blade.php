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
        <main style="margin-top: 50px; overflow-x: hidden">
            @yield('content')
        </main>
        <!-- footer -->
        <footer class="container-fluid" style="background-color: #363435 !important">
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
                    <img src="{{ asset('img/cecelia-logo-black-bg.png') }}" class="img-responsive" style="width:120px" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mx-auto p-3">
                    <span style="font-size: 25px" class="h1-strong orange-text">Cities</span>
                    <ul class="list-group">
                        <li class="list-group-item white-text transparent p-1" style="border-width: 0px">Lagos</li>
                    </ul>
                </div>
                <?php $categories = \App\Category::orderby('category_name', 'ASC')->get(); ?>
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
        <!-- unit measurement modal -->
        <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-bottom modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h1-strong w-100" id="unitModalLabel">
                            Unit Measurements
                        </h4>
                        <a class="btn btn-sm p-2 bg-red-orange shadow-none" data-dismiss="modal">
                            <span class="white-text">X</span>
                        </a>
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
        <!-- Recipe of the week modal -->
        <div class="modal fade" id="weekRecipeModal" tabindex="-1" role="dialog" aria-labelledby="weekRecipeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-bottom modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h1-strong w-100" id="weekRecipeModalLabel">
                            Recipe for the Week
                        </h4>
                        <a class="btn btn-sm p-2 bg-red-orange shadow-none" data-dismiss="modal">
                            <span class="white-text">X</span>
                        </a>
                    </div>
                    <div class="modal-body pad-bot-50" style="text-align: center !important">
                        <?php $recipe = \App\Recipe::orderby('id', 'DESC')->take(1)->get(); ?>
                        <form method="POST" action="{{ route('console.newRecipe') }}">
                            <div class="row">
                                <div class="col-md-10 mx-auto md-form">
                                    <label class="active">Title</label>
                                    @csrf
                                    <input type="text" class="form-control" value="@if(count($recipe) > 0) {{ $recipe[0]->title }} @endif" name="rec_title" placeholder="Making Egusi Soup to die for" required />
                                </div>
                                <div class="col-md-10 mx-auto md-form">
                                    <label class="active">Image URL</label>
                                    <input type="text" class="form-control" value="@if(count($recipe) > 0) {{ $recipe[0]->image_url }} @endif" name="rec_image" placeholder="https://howto.com/egusi_soup.png" required />
                                </div>
                                <div class="col-md-10 mx-auto md-form">
                                    <label class="active">Steps</label>
                                    <textarea class="md-textarea" name="rec_steps" style="overflow-y:auto;min-height:150px; width: 90%" required >@if(count($recipe) > 0){!! $recipe[0]->steps !!}@endif</textarea>
                                </div>
                                <div class="col-12 mx-auto align-center">
                                    <button type="submit" class="btn btn-danger bg-red-orange capitalize white-text"><span class="fa fa-plus"></span>&nbsp;Add New Recipe</button> 
                                </div>
                            </div>
                        </form>
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
