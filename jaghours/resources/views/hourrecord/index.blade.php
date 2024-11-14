@extends('layouts.app')

@section('content')

<head>
<style>
    .job-card {
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .job-card:hover {
        transform: translateY(-5px);
    }

    .job-card-avatar {
        display: inline-block;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #219EBC;
        color: #fff;
        text-align: center;
        line-height: 50px;
        font-size: 24px;
        margin-right: 15px;
    }

    .job-card-title {
        font-size: 1.75rem; /* Aumentar tamaño de título */
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .job-card-area {
        color: #666;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .job-card-date {
        color: #219EBC;
        font-size: 0.9rem;
        font-weight: bold;
    }

    .job-card-description {
        margin-top: 15px;
        color: #444;
        font-size: 1rem; /* Tamaño de texto más grande */
        line-height: 1.8; /* Mayor interlineado */
    }

    .job-card-image {
        width: 100%; /* Asegura que la imagen ocupe el ancho completo */
        border-radius: 10px;
        margin-top: 15px;
    }

    .job-card-placeholder {
        width: 100%;
        height: 200px; /* Altura del cuadro de marcador de posición */
        background-color: #E0F2F1; /* Color de fondo del marcador de posición */
        border: 1px solid #ccc; /* Borde sólido */
        display: flex;
        justify-content: center;
        align-items: center;
        color: #aaa;
        font-size: 1.5rem; /* Tamaño del texto */
        text-align: center;
        margin-top: 10px;
        border-radius: 10px; /* Bordes redondeados */
        position: relative;
    }

    .job-card-placeholder:before {
        content: "Sin Imagen"; /* Texto en el cuadro */
        position: absolute;
        font-size: 1rem; /* Tamaño del texto */
        color: #666; /* Color del texto */
    }

    .job-card-details {
        margin-top: 15px;
        font-size: 0.9rem;
        color: #666;
    }

    .job-card-status {
        margin-top: 15px;
    }

    .custom-badge {
        display: inline-block;
        padding: 0.25em 0.5em;
        background-color: #E0F2F1; /* Fondo más claro */
        color: #219EBC; /* Letras en color #219EBC */
        border-radius: 0.25rem;
        font-size: 0.9rem;
    }

    .btn-action {
        background-color: #17699E;
        border: none;
        padding: 10px 20px;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-action:hover {
        background-color: #0F456E;
    }

    /* Estilos para la paginación */
    .pagination .page-link {
        color: #219EBC; 
        background-color: white; 
        border: 1px solid #ddd; 
    }

    .pagination .page-link:hover {
        background-color: #f1f1f1; 
    }

    .pagination .page-item.active .page-link {
        background-color: #219EBC; 
        color: white; 
    }

    .pagination .page-item.disabled .page-link {
        color: #ccc; 
    }

    .row {
        margin-bottom: 20px;
    }

</style>
</head>

<div class="container mt-4">
    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'areamanager')
        <h1 class="">Trabajos a Convalidar</h1>

        <form action="{{ route('job.index') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label for="year" class="form-label">Año</label>
            <select name="year" id="year" class="form-select">
                @foreach(range(2020, now()->year) as $yearOption)
                    <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="month" class="form-label">Mes</label>
            <select name="month" id="month" class="form-select">
                @foreach(range(1, 12) as $monthOption)
                    <option value="{{ $monthOption }}" {{ $month == $monthOption ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::createFromDate(null, $monthOption, 1)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end"> <!-- Alinea el botón al final de la columna -->
            <button type="submit" class="btn btn-primary mt-2" style="background-color: #17699E; border: none; width: 100%;">Filtrar</button>
        </div>
    </div>
</form>

        @foreach($jobOpportunities as $joboportunity)
                <div class="job-card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="d-flex align-items-center">
                        <div class="job-card-avatar">
                            {{ strtoupper(substr($joboportunity->area_managers->areas->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="job-card-title">{{ $joboportunity->title }}</div>
                            <div class="job-card-area">
                                <span>{{ $joboportunity->area_managers->areas->name }}</span>
                            </div>
                            <div class="job-card-date">Fecha de publicación: 
                                <span>{{ $joboportunity->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @if($joboportunity->image_path)
                    <img src="{{ asset($joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="job-card-image">
                    @else
                    <div class="job-card-placeholder">
                                
                     </div>
                        @endif
                    <div class="job-card-description mt-3">
                        {{ $joboportunity->description }}
                    </div>
                    <div class="job-card-details mt-3">
                        <span class="fw-bold" style="color:#219EBC;">Total Horas Convalidadas:</span>
                        <span class="fw-light" style="color:gray;"> {{ $joboportunity->hours_validated }} horas</span>
                        <br>
                        <span class="fw-bold" style="color:#219EBC;">Fecha de Inicio:</span>
                        <span class="fw-light" style="color:gray;">{{ $joboportunity->start_date }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="job-card-status">
                            <span class="custom-badge">{{ $joboportunity->status }}</span>
                        </div>
                        <div class="job-card-applicants">
                            @if($joboportunity-> match == 1)
                                <a href="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action">Convalidar</a>
                            

                            @else
                            <a href="{{ route('jobs.students', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action">Convalidar</a>
                            @endif
                        </div>
                    </div>
                </div>
          
        @endforeach
    @endif
</div>

@endsection


