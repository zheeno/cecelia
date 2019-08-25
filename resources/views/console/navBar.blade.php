<nav class="mb-1 navbar fixed-top m-0 navbar-expand-lg navbar-dark bg-red-orange">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('img/cecelia-logo-white-transparent-new.png') }}" class="img-reesponsive" style="width: 150px" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
        aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item @if($cur_page == 'dashboard') active @endif">
            <a class="nav-link" href="{{ route('console.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item  @if($cur_page == 'categories') active @endif">
            <a class="nav-link" href="{{ route('console.categories') }}">Manage Categories</a>
        </li>
        <li class="nav-item  @if($cur_page == 'measurements') active @endif">
            <a class="nav-link" data-toggle="modal" data-target="#unitModal">Unit Measurements</a>
        </li>
        <li class="nav-item  @if($cur_page == 'recipe') active @endif">
            <a class="nav-link" data-toggle="modal" data-target="#weekRecipeModal">Recipe for the Week</a>
        </li>
        <li class="nav-item  @if($cur_page == 'inventory') active @endif">
            <a class="nav-link" href="{{ route('console.inventory') }}">Inventory</a>
        </li>
        <li class="nav-item  @if($cur_page == 'orders') active @endif">
            <a class="nav-link" href="{{ route('console.orders') }}">Orders &amp; Delivery</a>
        </li>
        <li class="nav-item  @if($cur_page == 'users') active @endif">
            <a class="nav-link" href="{{ route('console.dashboard') }}">User Management</a>
        </li>
        <form id="logoutForm" method="POST" action="/logout">
            @csrf
            <li class="nav-item">
                <a class="nav-link" onClick="logout()">Log out</a>
            </li>
        </form>
        </ul>
    </div>
</nav>
