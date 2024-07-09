@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <div class="profile-circle">
                        <span>{{ substr($student->user->name, 0, 1) }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('student.updateProfile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3"><strong>CIF:</strong> {{ $student->user->cif }}</div>
                        <div class="mb-3"><strong>Nombre:</strong> {{ $student->user->name }}</div>
                        <div class="mb-3"><strong>Apellido:</strong> {{ $student->user->lastname }}</div>
                        <div class="mb-3"><strong>Correo:</strong> {{ $student->user->email }}</div>

                        <div class="form-group">
                            <label for="phone"><strong>Telefono:</strong></label>
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
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 12px 20px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color:#219EBC;
        color: #fff;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-circle span {
        text-transform: uppercase;
    }

    .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn {
        width: 100%;
    }
</style>

@endsection
