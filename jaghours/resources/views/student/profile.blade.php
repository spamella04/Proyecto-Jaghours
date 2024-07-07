@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="card-body">
        <div class="card">
            <div class="card-header">Perfil estudiante</div>

            <div class="card-body">
                <form action="{{ route('student.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div><strong>CIF:</strong> {{ $student->user->cif }}</div>
                    <div><strong>Nombre:</strong> {{ $student->user->name }}</div>
                    <div><strong>Apellido:</strong> {{ $student->user->lastname }}</div>
                    <div><strong>Correo</strong> {{ $student->user->email }}</div>

                    <div class="form-group">
                        <label for="phone"><strong>Telefono:</strong></label>
                        <input type="text" id="phone" name="phone" value="{{ $student->user->phone }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="skills"><strong>Habilidades:</strong></label>
                        <input type="text" id="skills" name="skills" value="{{ $student->skills }}" class="form-control">
                    </div>

                    <div><strong>Carrera:</strong> {{ $student->degree->name }}</div>

                    <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card-body {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px; /* Adjust spacing as needed */
        }

        .progress-bar {
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</div>

@endsection
