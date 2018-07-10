<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('Taviyani_Logo.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('Taviyani_Logo.png')}}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Taviyani Driving School</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.1/litera/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    @yield('css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{asset('Taviyani_Logo.png')}}" width="100" height="60">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/table" target="_blank">View Table</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Instructors
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/instructor/create') }}">Add new</a>
                        <a class="dropdown-item" href="{{ url('/instructor') }}">View all</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Students
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/student/create') }}">Add new</a>
                        <a class="dropdown-item" href="{{ url('/student') }}">View all</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Vehicles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/vehicle/create') }}">Add new</a>
                        <a class="dropdown-item" href="{{ url('/vehicle') }}">View all</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="wrap" style="padding-top: 50px; padding-bottom: 100px;">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    @yield('js')
</body>
</html>
