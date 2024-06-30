@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full px-6 py-8 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">{{ __('Iniciar Sesion') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-600">{{ __('Correo') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('email') is-invalid @enderror">

                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-600">{{ __('Contraseña') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 @error('password') is-invalid @enderror">

                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                    class="form-checkbox h-4 w-4 text-blue-500 mr-2">
                <label for="remember" class="text-sm text-gray-600">{{ __('Remember Me') }}</label>
            </div>

            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    {{ __('Iniciar sesion') }}
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm text-center">
                    <a href="{{ route('password.request') }}"
                        class="text-blue-500 hover:text-blue-700">{{ __('Olvidaste tu contraseña?') }}</a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

