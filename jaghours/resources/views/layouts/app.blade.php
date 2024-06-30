<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Nunito">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.0/dist/alpine.min.js" defer></script>
</head>
<body>
    <div id="app">
        <nav class="bg-white shadow-sm">
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
                                @if (Route::has('login'))
                                    <li>
                                        <a class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li>
                                        <a class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" href="{{ route('register') }}">{{ __('Crear Cuenta') }}</a>
                                    </li>
                                @endif
                            @else
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
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navbar', () => ({
                open: false,
            }));
        });
    </script>
</body>
</html>
