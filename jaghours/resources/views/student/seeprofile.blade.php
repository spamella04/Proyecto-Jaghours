@extends('layouts.app')

<head>
    <style>

        .bg-circle{
            background-color: #219EBC;
        }
    </style>
</head>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $student->user->name }} {{ $student->user->lastname }} - Perfil</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($student->image_path && file_exists(public_path($student->image_path)))
                                <img src="{{ asset($student->image_path) }}" alt="Foto de Perfil" class="img-fluid rounded-circle">
                            @else
                                <div class="d-flex justify-content-center align-items-center bg-circle text-white rounded-circle" style="width: 250px; height: 250px; font-size: 80px;">
                                    {{ strtoupper(substr($student->user->name, 0, 1)) }}{{ strtoupper(substr($student->user->lastname, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $student->user->name }} {{ $student->user->lastname }}</h3>
                            <p><strong>CIF:</strong> {{ $student->user->cif }}</p>
                            <p><strong>Correo Electrónico:</strong> {{ $student->user->email }}</p>
                            <p><strong>Teléfono:</strong> {{ $student->user->phone }}</p>
                            <p><strong>Carrera:</strong> {{ $student->getDegree() }}</p>
                            <p><strong>Fecha de Ingreso:</strong> {{ $student->fecha_de_ingreso }}</p>
                            <p><strong>Habilidades:</strong> {{ $student->skills }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
