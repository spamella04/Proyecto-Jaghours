@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Estudiantes Aplicantes</h1>
    <table class="table">
        <thead>
            <tr>
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
                    <td>{{ $job->student->user->name }}</td>
                    <td>{{ $job->student->user->email }}</td>
                    <td>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $hoursLogged }} / {{ $totalHoursRequired }} horas
                            </div>
                        </div>
                    </td>
                    <td>
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
