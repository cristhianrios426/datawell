<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/helpers.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script>       
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'URL' => config('app.url'),

        ]) !!};
        window.URL = window.Laravel.URL;
    </script>
    @yield('head')
</head>
<body class="cpven-style">
    <div loader="" >
      <img src="{{ asset('img/l.gif') }}  " alt="">
    </div>
    <div id="app">
        <nav class="navbar main-navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand " href="{{ url('/') }}">
                        <div class="logo">
                            <img src="{{ asset('img/cpven-logo-35a.png') }}" alt="">
                        </div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @foreach (\App\ORM\Location::where('parent_id',0)->get() as $country)                            
                            <li>
                                <a href="{{{ route('index') }}}?country_id={{$country->getKey()}}">{{ $country->name }}</a>
                            </li>
                        @endforeach
                        
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.sendajax.js') }}"></script>
    <script src="{{ asset('js/boot.js?time='.time()) }}"></script>
    @yield('footer')
</body>
</html>
