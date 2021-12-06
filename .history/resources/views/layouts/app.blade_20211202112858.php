<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
</head>
<body class="fundo_tela">
    <div class="wrapper row1">
        <header id="header" class="hoc clear">
          <!-- ################################################################################################ -->
          <h1><a href="index.html">Shalamanaias</a></h1>
          <p>Locadora de Veículos</p>
          <!-- ################################################################################################ -->
        </header>
      </div>    <div id="app">
        <div class="wrapper row4">
            <nav id="mainav" class="hoc clear">
              <!-- ################################################################################################ -->
              <ul class="clear">
                <li class="active"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></li>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">teste</span>
                </button>
                <li><a class="drop" href="#">Pages</a>
                  <ul>
                    <li><a href="pages/gallery.html">Gallery</a></li>
                    <li><a href="pages/full-width.html">Full Width</a></li>
                    <li><a href="pages/sidebar-left.html">Sidebar Left</a></li>
                    <li><a href="pages/sidebar-right.html">Sidebar Right</a></li>
                    <li><a href="pages/basic-grid.html">Basic Grid</a></li>
                  </ul>
                </li>
                <li><a class="drop" href="#">Dropdown</a>
                  <ul>
                    <li><a href="#">Level 2</a></li>
                    <li><a class="drop" href="#">Level 2 + Drop</a>
                      <ul>
                        <li><a href="#">Level 3</a></li>
                        <li><a href="#">Level 3</a></li>
                        <li><a href="#">Level 3</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Level 2</a></li>
                  </ul>
                </li>
                <li><a href="#">Link Text</a></li>
                <li><a href="#">Link Text</a></li>
                <li><a href="#">Link Text</a></li>
                <li><a href="#">Long Link Text</a></li>
              </ul>
              <!-- ################################################################################################ -->
            </nav>
          </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('clientes') }}">Clientes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('locacoes') }}">Lotações</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Veículos</a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('marcas') }}">Marcas</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('modelos') }}">Modelos</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('carros') }}">Carros</a>
                                </div>
                            </li>
                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <img src="{{ asset('img/log-in.svg') }}" alt="botão login">
                                        Login
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                        <img src="{{ asset('img/log-out.svg') }}" alt="botão logout">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @auth
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Route::currentRouteName() }}</li>
                </ol>
            </nav>
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
