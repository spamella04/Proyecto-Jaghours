@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reporte de Horas Trabajadas</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('hourrecords.report') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="semester_id">Semestre <span class="text-danger">*</span></label>
                    <select id="semester_id" name="semester_id" class="form-control">
                        <option value="">Seleccione un semestre</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="degree_id">Carrera</label>
                    <select id="degree_id" name="degree_id" class="form-control">
                        <option value="">Seleccione una carrera</option>
                        @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}" {{ request('degree_id') == $degree->id ? 'selected' : '' }}>
                                {{ $degree->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="status_filter">Estado de Horas</label>
                    <select id="status_filter" name="status_filter" class="form-control">
                        <option value="">Seleccione un estado</option>
                        <option value="Completadas" {{ request('status_filter') == 'Completadas' ? 'selected' : '' }}>Completadas</option>
                        <option value="Sin Completar" {{ request('status_filter') == 'Sin Completar' ? 'selected' : '' }}>Sin Completar</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="cif_search">Buscar por CIF</label>
                    <input type="text" id="cif_search" name="cif_search" class="form-control" value="{{ request('cif_search') }}" placeholder="Ingrese CIF">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex align-items-end mt-3">
                <!-- Botón Filtrar -->
                <form method="GET" action="{{ route('hourrecords.report') }}" class="d-flex align-items-center">
                    <button type="submit" class="btn" style="background-color: #219EBC; color: white;">Filtrar</button>
                </form>

                <!-- Botón Exportar a Excel con margen izquierdo -->
                <form action="{{ route('report.export') }}" method="GET" class="ml-2">
                    <input type="hidden" name="semester_id" value="{{ request()->input('semester_id') }}">
                    <input type="hidden" name="degree_id" value="{{ request()->input('degree_id') }}">
                    <input type="hidden" name="cif_search" value="{{ request()->input('cif_search') }}">
                    <input type="hidden" name="status_filter" value="{{ request()->input('status_filter') }}">

                    <button type="submit" id="exportButton" class="btn ml-2" style="background-color: #219EBC; color: white; margin-left: 10px;"data-students-empty="{{ $students->isEmpty() ? 'true' : 'false' }}" disabled>Exportar a Excel</button>
                </form>
            </div>
        </div>
    </form>

    <!-- Mensaje de error si no se selecciona un semestre -->
    @if(isset($error))
        <div class="alert alert-warning">
            {{ $error }}
        </div>
    @endif

    <!-- Tabla de Reporte -->
    @if($students->isEmpty())
        <div class="alert alert-info">
            No se encontraron resultados.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>CIF</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Total Horas Trabajadas</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>
                            <a href="{{ route('hourrecords.student', ['student' => $student['student']->id, 'semester_id' => request('semester_id')]) }}" style="color: #219EBC;">
                                {{ $student['student']->user->cif ?? 'N/A' }}
                            </a>
                        </td>
                        <td>{{ $student['student']->user->name }} {{ $student['student']->user->lastname }}</td>
                        <td>{{ $student['student']->degree->name ?? 'N/A' }}</td>
                        <td>{{ $student['total_hours'] ?? 0 }}</td>
                        <td>{{ $student['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const exportButton = document.getElementById("exportButton");
        const semesterFilter = document.getElementById("semester_id");

        // Función para verificar si el botón debe habilitarse
        function checkFilters() {
            const isSemesterSelected = semesterFilter.value !== "";
            const isStudentsEmpty = exportButton.getAttribute("data-students-empty") === "true";

            // El botón se habilita solo si hay un semestre seleccionado y existen estudiantes
            exportButton.disabled = !isSemesterSelected || isStudentsEmpty;
        }

        // Ejecutar la función al cargar la página
        checkFilters();

        // Añadir evento al cambio del filtro de semestre
        semesterFilter.addEventListener("change", checkFilters);
    });
</script>
</div>


@endsection
