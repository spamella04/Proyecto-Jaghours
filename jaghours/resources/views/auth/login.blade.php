@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-sm w-100" style="max-width: 28rem;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">{{ __('Iniciar sesión') }}</h2>
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

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                    <div class="input-group">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="form-control @error('password') is-invalid @enderror">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye-slash"></i> 
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" style="background-color: #219EBC; border-color: #219EBC;">
                        {{ __('Iniciar sesión') }}
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #219EBC;">{{ __('¿Olvidaste tu contraseña?') }}</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    // Alternar visibilidad de la contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        // Cambiar entre tipo 'password' y 'text'
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        // Cambiar ícono
        if (passwordInput.type === 'password') {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
