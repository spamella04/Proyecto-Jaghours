@extends('layouts.app')

@section('content')

<head>
    <style>
        .custom-badge {
            display: inline-block;
            padding: 0.25em 0.5em;
            background-color: #219EBC;
            color: #fff;
            border-radius: 0.25rem;
            /* Bordes redondeados */
        }

        .job-card-hours {
            margin-top: 15px;
            text-align: right;
        }

        .job-card-hours a.btn {
            background-color: #219EBC;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .job-card-hours a.btn:hover {
            background-color: #17699E;
        }

        .form-select-arrow {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%23333' d='M1.224 4.776a.75.75 0 0 1 1.06 0L8 10.94l5.716-6.164a.75.75 0 1 1 1.06 1.06l-6 6.5a.75.75 0 0 1-1.06 0l-6-6.5a.75.75 0 0 1 0-1.06z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 1.5em 1.5em;
        }

    </style>
</head>

<div class="container py-5">
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
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h3 class="mb-0">Registrar horas de trabajo</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('hourrecords.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">

                        <div class="mb-3">
                            <label for="title" class="form-label font-weight-bold">Título del trabajo</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $job->job_opportunity->title }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label font-weight-bold">Descripción del trabajo</label>
                            <textarea class="form-control" id="description" name="description"
                                readonly>{{ $job->job_opportunity->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="student" class="form-label font-weight-bold">Estudiante</label>
                            <input type="text" class="form-control" id="student" name="student"
                                value="{{ $job->student->user->name }} {{ $job->student->user->lastname }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="cif" class="form-label font-weight-bold">CIF del estudiante</label>
                            <input type="text" class="form-control" id="cif" name="cif"
                                value="{{ $job->student->user->cif }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="semester_id" class="form-label font-weight-bold">Semestre</label>
                            <select class="form-select @error('semester_id') is-invalid @enderror" id="semester_id"
                                name="semester_id" required>
                                <option value="">Seleccione semestre</option>
                                @foreach($semesters as $semester)
                                 @if($semester->status == 'active')
                                <option value="{{ $semester->id }}" 
                                    data-start="{{ $semester->start_date }}" 
                                    data-end="{{ $semester->end_date }}"
                                    {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }} - {{ $semester->year }}
                                </option>
                                 @endif
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Trabajo -->
                        <div class="mb-3">
                            <label for="work_date" class="form-label font-weight-bold">Fecha de Trabajo</label>
                            <input type="date" class="form-control @error('work_date') is-invalid @enderror"
                                id="work_date" name="work_date" value="{{ old('work_date') }}"
                                required>
                            @error('work_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="hours_worked" class="form-label font-weight-bold">Horas trabajadas</label>
                            <input type="number" class="form-control @error('hours_worked') is-invalid @enderror"
                                id="hours_worked" name="hours_worked"
                                value="{{ old('hours_worked') }}" min="1"
                                max="{{ $maxHours - $totalHoursWorked }}" required>
                            @error('hours_worked')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!--
                        <div class="mb-3">
                            <label for="description" class="form-label font-weight-bold">Descripción de las Horas Trabajadas</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
@error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
@enderror
                        </div>
                    -->
                        <div class = "text-center">
                        <button type="submit" class="btn btn-primary"  style="background-color: #219EBC; border-color: #219EBC;">Registrar horas</button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos de semestre y fecha
    const semesterSelect = document.getElementById('semester_id');
    const workDateInput = document.getElementById('work_date');

    // Función para actualizar las fechas de trabajo disponibles
    function updateDateRange() {
        const selectedOption = semesterSelect.selectedOptions[0];
        const startDate = selectedOption.getAttribute('data-start');
        const endDate = selectedOption.getAttribute('data-end');
        
        // Establecer los valores de 'min' y 'max' para el input de fecha
        workDateInput.setAttribute('min', startDate);
        workDateInput.setAttribute('max', endDate);
    }

    // Llamar a la función al cambiar el semestre
    semesterSelect.addEventListener('change', updateDateRange);

    // Actualizar el rango de fechas al cargar la página si ya hay un semestre seleccionado
    if (semesterSelect.value) {
        updateDateRange();
    }
});
</script>

<script>
    // Obtener las horas máximas y las horas ya registradas del servidor
    const totalHoursWorked = {{ $totalHoursWorked }};
    const maxHours = {{ $maxHours }};
    const remainingHours = maxHours - totalHoursWorked;

    // Establecer el valor máximo dinámicamente
    const hoursInput = document.getElementById('hours_worked');
    hoursInput.setAttribute('max', remainingHours);

    // Mostrar el número de horas restantes para que el usuario lo vea
    const feedback = document.createElement('div');
    feedback.classList.add('form-text');
    feedback.textContent = `Horas restantes: ${remainingHours}`;
    hoursInput.parentElement.appendChild(feedback);
</script>


@endsection
