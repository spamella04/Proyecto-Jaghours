@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-sm w-100" style="max-width: 28rem;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">{{ __('Iniciar Sesión') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Correo') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="form-check-input">
                    <label for="remember" class="form-check-label">{{ __('Remember Me') }}</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"  style="background-color: #219EBC; border-color: #219EBC;">
                        {{ __('Iniciar sesión') }}
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #219EBC; ">{{ __('Olvidaste tu contraseña?') }}</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
