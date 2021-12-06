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
</head>
<body>
    <div id="app">
        <header class="p-3 bg-white text-dark">
            <nav class="navbar navbar-expand-md navbar-dark bg-navegador shadow-sm">
                <div class="container">
                    <a href="{{ url('/') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <img
                            src = "{{ asset('img/logomarca.svg') }}"
                            alt="Logomarca"
                            width="90"
                            height="82"/>
                    </a>

                    <a href="{{ url('/') }}" class="nav-link px-2 text-white">Home</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div
                        class="collapse navbar-collapse d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
                        id="navbarSupportedContent"
                    >

                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">

                            @auth
                                <li class="nav-item">
                                    <a href="{{ route('clientes') }}" class="nav-link px-2 text-white">
                                        Clientes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('locacoes') }}" class="nav-link px-2 text-white">
                                        Locações
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle px-2 text-white" data-toggle="dropdown">
                                        Veículos
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('marcas') }}">Marcas</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('modelos') }}">Modelos</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('carros') }}">Carros</a>
                                    </div>
                                </li>
                            @endauth

                            <li class="nav-item">
                                <a href="#" class="nav-link px-2 text-white">
                                    Quem somos
                                </a>
                            </li>

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
        </header>

        <main class="py-4">
            @yield('content')
        </main>
        <hr>
    </div>
    <div class="bg-navegador text-white">
        <div class="container">
            <footer class="py-4">
                <div class="row">
                    <div class="col-2">
                        <h5>Desenvolvedor</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Carlos Humberto Brasileiro Toscano</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Features</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Pricing</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">About</a></li>
                        </ul>
                    </div>

                    <div class="col-2">
                        <h5>Section</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Home</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Features</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Pricing</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">About</a></li>
                        </ul>
                    </div>

                    <div class="col-2">
                        <h5>Section</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Home</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Features</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">Pricing</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">FAQs</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-danger">About</a></li>
                        </ul>
                    </div>

                    <div class="col-5 offset-1">
                        <form>
                            <h5>Subscribe to our newsletter</h5>
                            <p>Monthly digest of whats new and exciting from us.</p>
                            <div class="d-flex w-100 gap-2">
                            <label for="newsletter1" class="visually-hidden">Email address</label>
                            <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-between py-4 my-4 border-top">
                    <p>&copy; 2021 Company, Inc. All rights reserved.</p>
                    <ul class="list-unstyled d-flex">
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
