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
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h3 class="mb-0">Registrar Horas de Trabajo</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('hourrecords.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">

                        <div class="mb-3">
                            <label for="title" class="form-label font-weight-bold">Título del Trabajo</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $job->job_opportunity->title }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label font-weight-bold">Descripción del Trabajo</label>
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
                            <label for="cif" class="form-label font-weight-bold">CIF del Estudiante</label>
                            <input type="text" class="form-control" id="cif" name="cif"
                                value="{{ $job->student->user->cif }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="semester_id" class="form-label font-weight-bold">Semestre</label>
                            <select class="form-select @error('semester_id') is-invalid @enderror" id="semester_id"
                                name="semester_id" required>
                                <option value="">Seleccione semestre</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}"
                                        {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }} - {{ $semester->year }}
                                    </option>
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
                            <label for="hours_worked" class="form-label font-weight-bold">Horas Trabajadas</label>
                            <input type="number" class="form-control @error('hours_worked') is-invalid @enderror"
                                id="hours_worked" name="hours_worked"
                                value="{{ old('hours_worked') }}" min="1"
                                max="{{ $job->job_opportunity->hours_validated }}" required>
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
                        <button type="submit" class="btn btn-primary"  style="background-color: #219EBC; border-color: #219EBC;">Registrar Horas</button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
