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
                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background-color: #219EBC;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $progress['totalHoursWorked'] }} horas de {{ $progress['requiredHours'] }}</div>
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
                            @php
                                $totalAcumuladoPorTrabajo = [];
                                $currentJobTitle = null;
                                $rowCount = 0;
                            @endphp
                            @foreach($progress['semester']->hourRecords as $hourRecord)
                                @php
                                    $tituloTrabajo = $hourRecord->job->job_opportunity->title;
                                    $area = $hourRecord->areaManager->areas->name;
                                    $fechaInicio = $hourRecord->work_date;
                                    $horasConvalidadas = $hourRecord->hours_worked;
                                    $rowCount++;

                                    if ($tituloTrabajo !== $currentJobTitle) {
                                        // Mostrar la fila de total acumulado si hay más de un registro para el trabajo anterior
                                        if ($currentJobTitle !== null && $rowCount > 1) {
                                            echo '<tr>';
                                            echo '<td colspan="3" class="text-start"><strong>Total acumulado por ' . $currentJobTitle . ':</strong></td>';
                                            echo '<td>' . $totalAcumuladoPorTrabajo[$currentJobTitle] . '</td>';
                                            echo '</tr>';
                                        }
                                        
                                        // Reiniciar acumulador para el nuevo trabajo
                                        $currentJobTitle = $tituloTrabajo;
                                        $totalAcumuladoPorTrabajo[$currentJobTitle] = 0;
                                        $rowCount = 0;
                                    }

                                    // Sumar horas convalidadas al total del trabajo actual
                                    $totalAcumuladoPorTrabajo[$currentJobTitle] += $horasConvalidadas;
                                @endphp
                                <tr>
                                    <td>{{ $tituloTrabajo }}</td>
                                    <td>{{ $area }}</td>
                                    <td>{{ $fechaInicio }}</td>
                                    <td>{{ $horasConvalidadas }}</td>
                                </tr>
                            @endforeach

                            @if ($currentJobTitle !== null && $rowCount > 1)
                                {{-- Mostrar el total acumulado para el último trabajo si tiene más de un registro --}}
                                <tr>
                                    <td colspan="3" class="text-start"><strong>Total acumulado por {{ $currentJobTitle }}:</strong></td>
                                    <td>{{ $totalAcumuladoPorTrabajo[$currentJobTitle] }}</td>
                                </tr>
                            @endif
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
