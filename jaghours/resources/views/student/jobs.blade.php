@extends('layouts.app')

@section('content')

<div class="container py-5">
    <!-- Formulario para seleccionar el semestre -->
    <form method="GET" action="{{ route('student.jobs') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <h1 class="text-nowrap">Mi historial de horas trabajadas</h1>
                    <select id="semester_id" name="semester_id" class="form-control" required>
                        <option value="">Seleccione un semestre</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-group mb-0">
                    <button type="submit" class="btn" style="background-color: #219EBC; color: white;">Ver historial</button>
                </div>
            </div>
        </div>
    </form>

    @if($semesterProgress)
        <!-- Detalles del semestre seleccionado -->
        <div class="card shadow-sm rounded-lg mb-4">
            <div class="card-body">
                <h3 class="font-weight-bold">{{ $semesterProgress['semester']->name }}</h3>
                <div class="progress mt-3">
                    @php
                        $percentage = $semesterProgress['percentage'] > 100 ? 100 : $semesterProgress['percentage'];
                    @endphp
                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background-color: #219EBC;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $semesterProgress['totalHoursWorked'] }} horas de {{ $semesterProgress['requiredHours'] }}</div>
                </div>
                <p class="mt-2"><strong>Total acumulado:</strong> {{ $semesterProgress['totalHoursWorked'] }} horas</p>
                <p><strong>Horas requeridas en el semestre:</strong> {{ $semesterProgress['requiredHours'] }} horas</p>

                <!-- Detalles de los trabajos asociados a este semestre -->
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Área</th>
                                <th scope="col">Fecha de inicio</th>
                                <th scope="col">Horas convalidadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentJobTitle = null;
                                $totalAcumuladoPorTrabajo = [];
                            @endphp
                            @foreach($semesterProgress['hourRecords'] as $hourRecord)
                                @php
                                    $tituloTrabajo = $hourRecord->job->job_opportunity->title;
                                    $area = $hourRecord->job->job_opportunity->area_managers->areas->name ?? 'N/A';
                                    $fechaInicio = $hourRecord->work_date;
                                    $horasConvalidadas = $hourRecord->hours_worked;

                                    if ($tituloTrabajo !== $currentJobTitle) {
                                        // Mostrar el total acumulado por el trabajo anterior si hay más de un registro
                                        if ($currentJobTitle !== null) {
                                            echo '<tr>';
                                            echo '<td colspan="3" class="text-start"><strong>Total acumulado por ' . $currentJobTitle . ':</strong></td>';
                                            echo '<td>' . $totalAcumuladoPorTrabajo[$currentJobTitle] . '</td>';
                                            echo '</tr>';
                                        }

                                        // Reiniciar acumulador para el nuevo trabajo
                                        $currentJobTitle = $tituloTrabajo;
                                        $totalAcumuladoPorTrabajo[$currentJobTitle] = 0;
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

                            <!-- Mostrar el total acumulado por el último trabajo -->
                            @if ($currentJobTitle !== null)
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
    @endif

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
