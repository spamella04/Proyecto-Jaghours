@extends('layouts.app')

@section('content')

<div class="container py-5">

    <!-- Iterar sobre cada semestre y mostrar detalles -->
    @foreach($semesterProgress as $progress)
        <div class="card shadow-sm rounded-lg mb-4">
            <div class="card-body">
                <h3 class="font-weight-bold">{{ $progress['semester']->name }}</h3>
                <div class="progress mt-3">
                    @php
                        $percentage = $progress['percentage'] > 100 ? 100 : $progress['percentage'];
                    @endphp
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $progress['totalHoursWorked'] }} horas de {{ $progress['requiredHours'] }}</div>
                </div>
                <p class="mt-2"><strong>Total acumulado:</strong> {{ $progress['totalHoursWorked'] }} horas</p>
                <p><strong>Horas requeridas en el semestre:</strong> {{ $progress['requiredHours'] }} horas</p>

                <!-- Detalles de los trabajos asociados a este semestre -->
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Área</th>
                                <th scope="col">Fecha de Inicio</th>
                                <th scope="col">Horas Convalidadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($progress['semester']->hourRecords as $hourRecord)
                                <tr>
                                    <td>{{ $hourRecord->job->job_opportunity->title }}</td>
                                    <td>{{ $hourRecord->areaManager->areas->name }}</td>
                                    <td>{{ $hourRecord->work_date }}</td>
                                    <td>{{ $hourRecord->hours_worked }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

</div>

<style>
    .card-body {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
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

@endsection
