@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light py-4">
    <div class="card shadow-sm" style="max-width: 28rem;">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">{{ __('Crear Cuenta') }}</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="cif" class="form-label">{{ __('CIF') }}</label>
                    <input id="cif" name="cif" type="text" class="form-control @error('cif') is-invalid @enderror" value="{{ old('cif') }}" required>
                    @error('cif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">{{ __('Nombre') }}</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="lastname" class="form-label">{{ __('Apellido') }}</label>
                        <input id="lastname" name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" required>
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Correo') }}</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
                    <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class ="mb-3">
                    <label for="fecha_de_ingreso" class="form-label font-weight-bold">Fecha de ingreso a la universidad</label>
                            <input type="date" class="form-control @error('fecha_de_ingreso') is-invalid @enderror"
                                id="fecha_de_ingreso" name="fecha_de_ingreso" value="{{ old('fecha_de_ingreso') }}"
                                required>
                            @error('fecha_de_ingreso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                </div>
                
                <div class="mb-3">
                    <label for="degree_id" class="form-label">{{ __('Carrera') }}</label>
                    <select id="degree_id" name="degree_id" class="form-select @error('degree_id') is-invalid @enderror" required>
                        <option value="">{{ __('Selecciona tu carrera principal') }}</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                        @endforeach
                    </select>
                    @error('degree_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="skills" class="form-label">{{ __('Habilidades') }}</label>
                    <textarea id="skills" name="skills" class="form-control @error('skills') is-invalid @enderror" rows="4" required>{{ old('skills') }}</textarea>
                    @error('skills')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                    <div class="input-group">
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword1">
                                    <i class="fas fa-eye-slash"></i> 
                                </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                    <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword2">
                                        <i class="fas fa-eye-slash"></i> 
                                    </button>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" style="background-color: #219EBC; border-color: #219EBC;">{{ __('Registrarse') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    // Alternar visibilidad de la contraseña para el campo 'password'
    document.getElementById('togglePassword1').addEventListener('click', function () {
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

    // Alternar visibilidad de la contraseña para el campo 'password-confirm'
    document.getElementById('togglePassword2').addEventListener('click', function () {
        const passwordInput = document.getElementById('password_confirmation');
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