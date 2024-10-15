@extends('layouts.app') 

@section('content')

<style>
    .job-card {
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
        font-size: 1.5rem; 
        font-weight: bold;
        margin-bottom: 10px;
    }

    .job-card-area {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .job-card-date {
        color: #219EBC;
        font-size: 0.9rem;
        font-weight: bold;
    }

    .job-card-description {
        margin-top: 10px;
        color: #333;
        font-size: 1rem;
        line-height: 1.5;
    }

    .job-card-details {
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .job-card-status {
        margin-top: 10px;
    }

    .custom-badge {
        display: inline-block;
        padding: 0.25em 0.5em;
        background-color: #E0F2F1;
        color: #219EBC;
        border-radius: 0.25rem;
        font-size: 0.9rem;
    }

    .job-card-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 15px;
        max-height: 200px; /* Limitar la altura máxima de la imagen */
        object-fit: cover; /* Ajustar la imagen */
    }

    .job-card-placeholder {
        width: 100%;
        height: 200px; /* Altura del cuadro de color */
        background-color: #E0F2F1; /* Color de fondo */
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem; /* Tamaño de texto */
        color: #666; /* Color del texto */
        font-weight: bold;
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

    .calendar-icon {
        font-size: 1.2rem; /* Tamaño del icono */
        color: #219EBC; /* Color del icono */
    }
</style>

@php
    $count = 0; // Inicializar el contador
@endphp

<div class="container mt-4">
  
    @if(Auth::user()->role == 'areamanager')
        <h1 class="">Solicitudes</h1>
        <a href="{{ route('joboportunity.create') }}" class="btn btn-primary mb-3" style="background-color: #219EBC; border-color: #219EBC;">Crear Nueva Solicitud</a>
        
        <div class="row">
       
            @foreach($jobOportunities as $joboportunity)
           @if($joboportunity->status != 'Pendiente')
                <div class="col-md-6">
                    <div class="job-card shadow-lg">
                    @if($joboportunity->image_path)
                            <img src="{{ asset('storage/' . $joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="job-card-image">
                        @else
                            <div class="job-card-placeholder">
                                Sin Imagen
                            </div>
                        @endif
                        <div class="d-flex align-items-center">
                            <div class="job-card-avatar">
                                {{ strtoupper(substr($joboportunity->area_managers->areas->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="job-card-title">{{ $joboportunity->title }}</div>
                                <div class="job-card-area">
                                    <span>{{ $joboportunity->area_managers->areas->name }}</span>
                                </div>
                                <div class="job-card-date"> Fecha solicitdo:
                                    
                                    {{ $joboportunity->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="job-card-description mt-3">
                            {{ $joboportunity->description }}
                        </div>
                        <div class="job-card-details mt-3">
                            <span class="fw-bold" style="font-size: 10px; color:#219EBC;">Total Horas Convalidadas:</span>
                            <span class="fw-light" style="color:gray;"> {{ $joboportunity->hours_validated }} horas</span>
                            <br>
                            <span class="fw-bold" style="font-size: 10px; color:#219EBC;">Fecha de Inicio:</span>
                            <span class="fw-light" style="color:gray;">{{ $joboportunity->start_date }}</span>
                        </div>
                        <div class="job-card-status mt-3">
                            <span class="custom-badge">{{ $joboportunity->status }}</span>
                        </div>
                    </div>
                </div>
                
                @if (($loop->index + 1) % 2 == 0) 
                    </div><div class="row"> <!-- Cierra y abre una nueva fila cada 2 publicaciones -->
                @endif 
                @php
                $count = 1; 
                @endphp
             @endif
            @endforeach

            @if($count == 0)
                <div class="alert alert-info">No hay solicitudes pendientes</div>
            @endif
        </div>


    @endif

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $jobOportunities->links() }} {{-- Esto generará los enlaces de paginación usando Bootstrap --}}
    </div>
</div>

@endsection
