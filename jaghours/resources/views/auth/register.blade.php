@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Crear Cuenta') }}
            </h2>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('students.store') }}" method="POST">
            @csrf
            <input type="hidden" name="remember" value="true">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="cif" class="sr-only">{{ __('CIF') }}</label>
                    <input id="cif" name="cif" type="text" autocomplete="cif" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('CIF') }}" value="{{ old('cif') }}">
                    @error('cif')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="degree_id" class="sr-only">{{ __('Carrera') }}</label>
                    <select id="degree_id" name="degree_id"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        required>
                        <option value="">{{ __('Selecciona tu carrera principal') }}</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                        @endforeach
                    </select>
                    @error('degree_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="name" class="sr-only">{{ __('Nombre') }}</label>
                    <input id="name" name="name" type="text" autocomplete="name" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Name') }}" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="lastname" class="sr-only">{{ __('Apellido') }}</label>
                    <input id="lastname" name="lastname" type="text" autocomplete="lastname" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Lastname') }}" value="{{ old('lastname') }}">
                    @error('lastname')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="sr-only">{{ __('Correo') }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Email Address') }}" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="sr-only">{{ __('Telefono') }}</label>
                    <input id="phone" name="phone" type="text" autocomplete="phone" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Phone') }}" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="skills" class="sr-only">{{ __('Habilidades') }}</label>
                    <input id="skills" name="skills" type="text" autocomplete="skills" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Skills') }}" value="{{ old('skills') }}">
                    @error('skills')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="sr-only">{{ __('Contraseña') }}</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Password') }}">
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">{{ __('Confirmar Contraseña') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        autocomplete="new-password" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="{{ __('Confirm Password') }}">
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <!-- Heroicon name: lock-closed -->
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M4 8a4 4 0 118 0 4 4 0 01-8 0zm14 1a1 1 0 01-1 1h-1v6a4 4 0 01-4 4H7a4 4 0 01-4-4v-6H2a1 1 0 01-1-1V7a5 5 0 119 0v1zm-6-3a2 2 0 012 2v1h-4V8a2 2 0 012-2h1z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    {{ __('Registrarse') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

