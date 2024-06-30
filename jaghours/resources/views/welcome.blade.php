<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a tu plataforma</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        /* Estilo adicional personalizado */
        .bg-custom-blue {
            background-color: #219EBC;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 p-4 flex justify-between items-center">
        <!-- Logo -->
        <div>
            <a href="#" class="text-xl font-bold text-gray-900 dark:text-white">JagHours</a>
        </div>
        <!-- Botones de inicio de sesión y registro -->
        <div>
            @auth
                <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar Sesión</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Crear Cuenta</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- Contenido de bienvenida -->
    <div class="min-h-screen flex items-center justify-center bg-custom-blue text-white">
        <div class="max-w-4xl px-6 py-16 mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">¡Bienvenido a la plataforma de Registro de Horas Laborales!</h1>
            <p class="text-lg md:text-xl mb-12">Encuentra las mejores oportunidades de trabajo para estudiantes y gestiona tus horas laborales de manera eficiente.</p>
            <!-- Espacio reservado para la imagen -->
            <div class="mb-12">
                 <img src="{{ asset('assets/images/estudiantes.jpg') }}" alt="Imagen de bienvenida" class="rounded-lg">  
    </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 py-4 text-center">
        <!-- Contenido del footer, como información de contacto o enlaces adicionales -->
    </footer>
</body>
</html>
