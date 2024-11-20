
@extends('layouts.app')

@section('content')
<head>
    <style>
    .btn-primary{
        background-color: #17A2B8;
        border-color: #17A2B8;
        color: #fff;
    }
    </style>
</head>

<div class="container">
    <h1>Registros de horas para {{ $student->user->name }} {{ $student->user->lastname }} </h1>
    <div class="row">
    <div class="col-md-6">
    <h2>{{$semester->name}}</h2>
    </div>
    <div class="col-md-6 d-flex justify-content-end align-items-center">
    <a href="{{ route('hourrecords.sendPDF', ['student' => $student->id, 'semester' => $semester->id]) }}" 
   class="btn btn-primary"
   onclick="return confirm('¿Estás seguro de enviar este PDF al administrador?');">
    Enviar PDF por correo
    </a>
    </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título del Trabajo</th>
                <th>Área</th>
                <th>Horas Trabajadas</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hourRecords as $hourRecord)
                <tr>
                    <td>{{ $hourRecord->job->job_opportunity->title ?? 'N/A' }}</td>
                    <td>{{ $hourRecord->job->job_opportunity->area_managers->areas->name ?? 'N/A' }}</td>
                    <td>{{ $hourRecord->hours_worked }}</td>
                    <td>{{ $hourRecord->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay registros de horas para este estudiante.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('hourrecords.report') }}" class="btn btn-secondary">Regresar</a>
</div>
@endsection
