@extends('layouts.app')

@section('content')

<head>
    <style>
        .btn-info {
            background-color: #17A2B8;
            border-color: #17A2B8;
            color: #fff;
        }
        .progress-bar {
            background-color: #17A2B8;
        }
        .btn-primary {
            background-color: #17A2B8;
            border-color: #17A2B8;
            color: #fff;
        }

        .btn-info:hover {
            background-color: #41c4d9;
        }

        .btn-primary:hover {
            background-color: #41c4d9;
            border-color: #17A2B8;
        }

       
        .btn-primary {
            margin-top: 20px; 
        }

       
        .search-form {
            margin-top: 30px; 
        }

      
        .table td, .table th {
            vertical-align: middle; 
            text-align: center; 
        }


        .action-cell {
        display: flex;
        justify-content: center;
        align-items: flex-start; 
        height: 100px; 
        padding-top: 10px; 
        }

      
        .progress-bar {
            background-color: #17A2B8;
        }

    
        .btn-celeste {
            background-color: #5baede; 
            border-color: #5baede; 
            color: #fff; 
            font-weight: bold;
        }

        .btn-celeste:hover {
            background-color: #4aa3c5; 
            color: #fff; 
            border-color: #4aa3c5;
        }

        .btn-celeste:focus, 
        .btn-celeste:active {
            background-color: #4aa3c5; 
            border-color: #4aa3c5;
            color: #fff; 
            box-shadow: none; 
        }
    </style>
</head>

<div class="container mt-4">
    <h1>Estudiantes Aplicantes</h1>

    <!-- Mensajes de alerta -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Verificación del estado -->
    <div class="container mt-2">
        @if(trim($jobOpportunity->status) === 'Asignacion Directa')
            <a href="{{ route('directjobopportunity.show', ['jobOpportunity' => $jobOpportunity->id]) }}" class="btn btn-celeste">Agregar Estudiante</a>
        @endif
    </div>

   
    <form action="{{ route('jobs.students', ['jobOpportunityId' => encrypt($jobOpportunity->id)]) }}" method="GET" class="mb-4 search-form">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por cif, nombre o apellido..." value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-info">Buscar</button>
                <a href="{{ route('jobs.students', ['jobOpportunityId' => encrypt($jobOpportunity->id)]) }}" class="btn btn-secondary btn-show-all">Mostrar todos</a>
            </div>
        </div>
    </form>
   
    
    <table class="table">
        <thead>
            <tr>
                <th>Cif</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Progreso</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                @php
                    // Obtener el total de horas convalidadas de los HourRecords asociados a este Job
                    $hoursLogged = $job->hourRecords->sum('hours_worked'); // Total de horas registradas
                    $totalHoursRequired = $job->job_opportunity->hours_validated; // Total de horas necesarias
                    $progressPercentage = $totalHoursRequired > 0 ? ($hoursLogged / $totalHoursRequired) * 100 : 0;
                    $isCompleted = $hoursLogged >= $totalHoursRequired; // Verificar si el progreso está completo
                @endphp
                <tr>
                    <td>{{ $job->student->user->cif }}</td>
                    <td>{{ $job->student->user->name }} {{ $job->student->user->lastname }}</td>
                    <td>{{ $job->student->user->email }}</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $hoursLogged }} / {{ $totalHoursRequired }} horas
                            </div>
                        </div>
                    </td>
                    <td class="action-cell">
                        <!-- Botón deshabilitado si el progreso está completo -->
                        <a href="{{ route('hourrecords.create', $job->id) }}" class="btn btn-primary btn-sm {{ $isCompleted ? 'disabled' : '' }}">
                            Agregar Horas
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection