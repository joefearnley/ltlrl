<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Little Url</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <nav class="nav">
        <div class="nav-left">
            <a class="nav-item" href="{{ url('/') }}">Little Url</a>
        </div>
        <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </span>
        <div class="nav-right nav-menu">
        <a class="nav-item">
            Home
        </a>
        @if (Auth::guest())
            <a href="{{ url('/login') }}" class="nav-item">Login</a>
            <a href="{{ url('/register') }}" class="nav-item">Register</a>
        @else
            @if (Auth::check() && Route::getCurrentRoute()->uri() != '/')
                <p class="control">
                    <a  id="show-add-url-form"class="button is-primary">
                        <span class="icon"><i class="fa fa-plus"></i></span>
                        <span>Make Little Url</span>
                    </a>
                </p>
            @endif
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/account') }}"><i class="fa fa-btn fa-user"></i> Account</a></li>
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                </ul>
            </li>
        @endif
    </nav>

    @yield('content')
    <script src="/js/lib.js"></script>
    <script src="/js/app.js"></script>
    @yield('scripts')
</body>
</html>
