@extends('layouts.app')

@section('content')

<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <div class="profile-circle">
                        <span>{{ substr($student->user->name, 0, 1) }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('student.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <!-- Imagen de perfil -->
                            <div class="profile-image-container">
                                @if ($student->image_path)
                                    <img src="{{ asset($student->image_path) }}" alt="Profile Image" class="profile-image" id="profile-image-preview">
                                @else
                                    <div class="profile-image-placeholder">
                                        <span>{{ substr($student->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <!-- Campo de selección de archivo -->
                                <input type="file" name="image" class="form-control-file" accept="image/*" onchange="previewImage(event)" id="profile-image-input">
                                <label for="profile-image-input" class="btn btn-secondary mt-2">Seleccionar archivo</label>
                            </div>
                        </div>

                        <div class="mb-3"><strong>CIF:</strong> {{ $student->user->cif }}</div>
                        <div class="mb-3"><strong>Nombre:</strong> {{ $student->user->name }}</div>
                        <div class="mb-3"><strong>Apellido:</strong> {{ $student->user->lastname }}</div>
                        <div class="mb-3"><strong>Correo:</strong> {{ $student->user->email }}</div>

                        <div class="form-group">
                            <label for="phone"><strong>Teléfono:</strong></label>
                            <input type="text" id="phone" name="phone" value="{{ $student->user->phone }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="skills"><strong>Habilidades:</strong></label>
                            <textarea id="skills" name="skills" class="form-control">{{ $student->skills }}</textarea>
                        </div>

                        <div><strong>Carrera:</strong> {{ $student->degree->name }}</div>

                        <button type="submit" class="btn btn-primary mt-4" style="background-color: #219EBC; border-color: #219EBC;">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Aseguramos que el contenedor ocupe toda la altura de la pantalla */
    .container-fluid {
        height: 100vh;
    }

    .row {
        height: 100%;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 20px;
        background-color: #219EBC;
    }

    .profile-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #fff;
        color: #219EBC;
        font-size: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #fff;
        margin: 0 auto;
    }

    .profile-circle span {
        text-transform: uppercase;
    }

    .profile-image-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-image-placeholder {
        width: 100%;
        height: 100%;
        background-color: #219EBC;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        border-radius: 50%;
    }

    .card-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
    }

    .form-control-file {
        display: none; /* Ocultar el input real de archivo */
    }

    .btn-secondary {
        display: inline-block;
        background-color: #6c757d;
        border-color: #6c757d;
        font-size: 14px;
        padding: 10px 15px;
        cursor: pointer;
    }

    /* Estilos responsivos */
    @media (max-width: 768px) {
        .profile-image-container {
            width: 100px;
            height: 100px;
        }

        .profile-circle {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        .card-body {
            padding: 20px;
        }

        .btn {
            font-size: 14px;
        }
    }
</style>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-image-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
 