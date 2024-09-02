
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registros de Horas para {{ $student->user->name }} {{ $student->user->lastname }}</h1>

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
