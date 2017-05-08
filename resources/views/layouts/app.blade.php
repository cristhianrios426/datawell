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
                    <a class="navbar-brand" href="{{ url('/well') }}">
                         <div class="logo">
                            <img src="{{ asset('img/cpven-logo-35a.png') }}" alt="">
                        </div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{{ route('well.index') }}}">Pozos</a>
                        </li>
                        <li>
                            <a href="{{{ route('service.index') }}}">Servicios</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                               Ajustes<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu multi-level" role="menu">
                                <li>
                                    <a href="{{ route('user.index') }}" >
                                        Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('operator.index') }}" >
                                        Operadores
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('block.index') }}" >
                                        Bloques
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('section.index') }}" >
                                        Secciones
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('well-type.index') }}" >
                                        Tipos de pozo
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('coordinate-sys.index') }}" >
                                        Sistemas de coordenadas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('area.index') }}" >
                                        Regiones
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cuenca.index') }}" >
                                        Cuencas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('camp.index') }}" >
                                        Campos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.index') }}" >
                                        Clientes
                                    </a>
                                </li> 
                                <li class="divider"></li>                               
                                <li class="dropdown dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tipos de servicio</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('service-type.index') }}">Servicios</a></li>
                                        <li><a href="{{ route('business-unit.index') }}">Unidades de negocios</a></li>                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            Salir
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js?time='.time()) }}"></script>
    <script src="{{ asset('vendors/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/validate/localization/messages_'.config('app.locale').'.min.js') }}"></script>    
    @yield('footer')
</body>
</html>
