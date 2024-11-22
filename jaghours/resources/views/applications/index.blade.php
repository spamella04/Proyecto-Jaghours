@extends('layouts.app') 

@section('content')

<style>
    .job-card-avatar {
        width: 60px; 
        height: 60px;
        border-radius: 50%;
        background-color: #219EBC !important;
        color: white;
        font-size: 26px; 
        font-weight: bold; 
        text-align: center;
        line-height: 60px; 
        border: 3px solid #fff;
    }

    .job-card-title {
        font-weight: bold;
        font-size: 1.1em; 
    }

    .job-card-description {
        color: #333;
        font-size: 0.9em;
        text-align: justify; 
    }

    .job-card-details {
        font-size: 0.9em;
        color: #555;
    }

    .badge {
        font-size: 0.85em;
        padding: 5px 10px;
    }

    .btn-custom {
        background-color: #219EBC;
        color: white;
        border-color: #219EBC; 
    }

    .btn-custom:hover {
        background-color: #1B88A7; 
        border-color: #1B88A7;
    }

    .form-check-input:checked {
        background-color: #219EBC;
        border-color: #219EBC;
    }

    .form-check-input:checked:focus {
        box-shadow: 0 0 0 0.2rem rgba(33, 158, 188, 0.25);
    }

    .form-check-input {

        border-color: #989898;
    }

</style>

<div class="container mt-4">
    <h1>Mis Postulaciones</h1>

    <!-- Filtro de Estado Compacto -->
    <form method="GET" action="{{ route('applications.index') }}" class="mb-4 d-flex align-items-center">
        
        
        <!-- Opción Todos -->
        <div class="form-check form-check-inline">
            <input type="checkbox" name="status_filter[]" value="Todos"
                   id="status_todos" class="form-check-input" 
                   {{ in_array('Todos', (array)$status_filter ?? []) ? 'checked' : '' }}>
            <label for="status_todos" class="form-check-label">Todos</label>
        </div>

        <!-- Opciones de Estado -->
        <div class="form-check form-check-inline">
            <input type="checkbox" name="status_filter[]" value="Pendiente" 
                   id="status_pendiente" class="form-check-input" 
                   {{ in_array('Pendiente', (array)$status_filter ?? []) ? 'checked' : '' }}>
            <label for="status_pendiente" class="form-check-label">Pendiente</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="status_filter[]" value="Aceptado" 
                   id="status_aceptado" class="form-check-input" 
                   {{ in_array('Aceptado', (array)$status_filter ?? []) ? 'checked' : '' }}>
            <label for="status_aceptado" class="form-check-label">Aceptado</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="status_filter[]" value="No Aceptado" 
                   id="status_noaceptado" class="form-check-input" 
                   {{ in_array('No Aceptado', (array)$status_filter ?? []) ? 'checked' : '' }}>
            <label for="status_noaceptado" class="form-check-label">No Aceptado</label>
        </div>
        
        <button type="submit" class="btn btn-custom btn-sm ms-2">Aplicar</button>
    </form>

    @if($applications->isEmpty() || $activeapplicationcount == 0)
        <p class="text-center">No tienes postulaciones registradas.</p>
    @else
        <div class="row">
            @foreach($applications as $application)
                @if($application->job_opportunities->area_managers->users->status == 'active')
                    <div class="col-md-4 mb-4">
                        <div class="job-card shadow-lg p-3 bg-white rounded d-flex flex-column h-100">
                            <div class="job-card-header d-flex align-items-center">
                                <!-- Círculo con la inicial del área -->
                                <div class="job-card-avatar d-flex justify-content-center align-items-center me-3">
                                    <strong>{{ strtoupper(substr($application->job_opportunities->area_managers->areas->name, 0, 1)) }}</strong>
                                </div>
                                <div>
                                    <!-- Título en negrita -->
                                    <div class="job-card-title font-weight-bold">{{ $application->job_opportunities->title }}</div>
                                    <div class="job-card-area">
                                        {{ $application->job_opportunities->area_managers->areas->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="job-card-description mt-3 flex-grow-1">
                                {{ Str::limit($application->job_opportunities->description, 120) }}
                            </div>
                            <div class="job-card-details mt-3">
                                <div><span class="fw-bold" style="color:#219EBC;">Total horas convalidadas:</span> {{ $application->job_opportunities->hours_validated }} horas</div>
                                <div><span class="fw-bold" style="color:#219EBC;">Fecha de inicio:</span> {{ $application->job_opportunities->start_date }}</div>
                            </div>
                            <div class="job-card-apply mt-3">
                                <!-- Estado con fondo coloreado -->
                                <p class="badge" style="background-color: 
                                    {{ $application->status == 'Aceptado' ? '#4CAF50' : ($application->status == 'Pendiente' ? '#FFC107' : '#F44336') }}; 
                                    color: white; opacity: 0.8; font-weight: bold;">
                                    {{ $application->status }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

@endsection



