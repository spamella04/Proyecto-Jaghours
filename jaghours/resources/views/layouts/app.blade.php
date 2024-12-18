<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('assets/images/LogoJaghoursSinFondo.png') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">


    <style>
        .nav-image {
            width: 100px;
            height: 100px;
        }

        .navbar-nav .nav-link {
            color: black;
            font-weight: 500;
        }

        .navbar-nav .nav-item {
            margin-right: 100px;
        }

        .nav-link.active {
            color: #219EBC !important;
        }

        .loading-scr {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-scr-inner {
            text-align: center;
        }

        .loading-scr-spinner img {

            width: 100px;
            animation: spin 3s linear infinite;
        }


        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Tailwind CSS -->
    <!--     <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
 -->
    <!-- Scripts -->
    <!--     <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.0/dist/alpine.min.js" defer></script>
 -->
</head>

<body>
    <div id="app">

        <div id="loading-screen" class="loading-scr">
            <div class="loading-scr-inner">
                <img class="loading-scr-logo" src="{{ asset('assets/images/LogoJagHours.png') }}" alt="Cargando...">
                <div class="loading-scr-spinner">
                    <img src="{{ asset('assets/images/loadingCircle.gif') }}" alt="Cargando...">
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <div class="logo-nav pl-2">
                   
                    @auth
                    @if(Auth::user()->role === 'student'|| Auth::user()->role === 'admin'|| Auth::user()->role === 'areamanager')
                    <a href="{{ url('/home') }}" class="navbar-brand h1">
                        <img src="{{ asset('assets/images/TituloJaghours.png') }}" alt="Logo Jaghours"
                            class="nav-image">
                    </a>
                    @endif
                    @endauth
                </div>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if(Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">{{ __('Iniciar sesion') }}</a>
                        </li>
                        @endif

                        @if(Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}"
                                href="{{ route('register') }}">{{ __('Crear cuenta') }}</a>
                        </li>
                        @endif
                        @else
                        @if(Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle {{ request()->is('students*') || request()->is('areamanagers*') || request()->is('areas*') || request()->is('degrees*') || request()->is('semesters*') ? 'active' : '' }}" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Configuracion
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('students.index') }}">Estudiantes</a>
                                <a class="dropdown-item" href="{{ route('areamanagers.index') }}">Responsable área</a>
                                <a class="dropdown-item" href="{{ route('areas.index') }}">Area</a>
                                <a class="dropdown-item" href="{{ route('degrees.index') }}">Carrera</a>
                                <a class="dropdown-item" href="{{ route('semesters.index') }}">Semestre</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('adminjobopportunities/show') ? 'active' : '' }}"
                                href="{{ route('adminjobopportunities.index') }}">Solicitudes</a>
                        </li>

                        <li class="nav-item">
                        <a class="nav-link {{ request()->is('adminjobopportunities/all') ? 'active' : '' }}"
                            href="{{ route('adminjobopportunities.allJobOpportunities') }}">Oportunidades</a>

                        </li>

                        <li class="nav-item dropdown">
                            <a id="hoursDropdown" class="nav-link dropdown-toggle {{ request()->is('job/show') || request()->is('completed-hours-report') ? 'active' : '' }}" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Horas Laborales
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="hoursDropdown">
                                <a class="dropdown-item" href="{{ route('job.index', ['year' => now()->year, 'month' => now()->month]) }}">Convalidar</a>
                                <a class="dropdown-item" href="{{ route('hourrecords.report') }}">Reportes</a>
                            </div>
                        </li>
                        @endif



                        @if(Auth::user()->role === 'areamanager')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('joboportunity/manager') ? 'active' : '' }}"
                                href="{{ route('joboportunity.index') }}">Solicitudes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('joboportunity/areamanager') ? 'active' : '' }}"
                                href="{{ route('joboportunity.indexAreaManager') }}">Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('job/show') ? 'active' : '' }}"
                                href="{{ route('job.index', ['year' => now()->year, 'month' => now()->month]) }}">Convalidar</a>
                        </li>


                        @endif

                        @if(Auth::user()->role === 'student')

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('joboportunity/showstudent') ? 'active' : '' }}"
                                href="{{ route('joboportunity.indexStudent') }}">Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('applications/showstudent') ? 'active' : '' }}"
                                href="{{ route('applications.index') }}">Postulaciones</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/jobs') ? 'active' : '' }}"
                                href="{{ route('student.jobs') }}">Historial</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/profile') ? 'active' : '' }}"
                                href="{{ route('student.profile') }}">Perfil</a>
                        </li>



                        @endif






                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar sesion') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}"
                                    method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- <nav class="bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <a class="text-xl font-bold text-gray-900" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button @click="open = !open" class="block lg:hidden focus:outline-none">
                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>

                    <div class="hidden lg:flex lg:items-center lg:w-auto" id="navbarSupportedContent" x-data="{ open: false }">
                        <ul class="flex flex-wrap space-x-4 lg:space-x-8 lg:ml-auto">
@guest
@if(Route::has('login'))
                                    <li>
                                        <a class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
                                    </li>
@endif

@if(Route::has('register'))
                                    <li>
                                        <a class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" href="{{ route('register') }}">{{ __('Crear Cuenta') }}</a>
                                    </li>
@endif
@else
@if(Auth::user()->role === 'admin')
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('students.index') }}">Estudiantes</a>
                                </li>
@endif

                                <li class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none">
                                        {{ Auth::user()->name }}
                                        <svg class="h-5 w-5 ml-2 -mr-1 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <ul x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
@csrf
                                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="#"
                                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
@endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav> -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Scripts -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navbar', () => ({
                open: false,
            }));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 500);
            }
        });

        // Muestra la pantalla al hacer clic en links
        document.addEventListener('click', function(event) {
            const link = event.target.tagName === 'A' ? event.target : event.target.closest('a');
            if (link && link.href && link.getAttribute('href') !== '#') {
                const loadingScreen = document.getElementById('loading-screen');
                if (loadingScreen) {
                    showLoadingScreen();
                }
            }

        });

        document.addEventListener('submit', function(event) {
            const form = event.target;

            if (form.tagName === 'FORM') {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton ) {
                    //  event.preventDefault(); // Prevenir el envío inmediato
                    showLoadingScreen(); // Mostrar la pantalla de carga

                    
                }
            }
        });



        // Función para mostrar la pantalla
        function showLoadingScreen() {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.display = 'flex';
            }
        }

        // Manejar el botón de regresar
        window.addEventListener('pageshow', function (event) {
            const loadingScreen = document.getElementById('loading-screen');

            if (loadingScreen) {
                if (event.persisted) {
                    // La página fue cargada desde el historial del navegador
                    loadingScreen.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>