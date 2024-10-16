@extends('layouts.app')

@section('content')
<head>
    <style>
        /* Contenedor principal */
        .container {
            display: flex;
            flex-wrap: wrap; /* Permite que las publicaciones se envuelvan en varias filas */
            justify-content: space-between; /* Espaciado entre publicaciones */
            margin-top: 20px;
            padding: 0 15px; /* Aumenta el espaciado lateral */
        }

        /* Contenedor de la publicación */
        .job-card {
            flex: 0 0 48%; /* Ancho del 48% para que quepan dos por fila */
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-bottom: 30px; /* Separación inferior */
        }

        .job-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Estilo del área y el círculo */
        .job-card-area {
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: #666;
            margin-bottom: 15px;
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
            font-weight: bold;
        }

        /* Estilo del título */
        .job-card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        /* Estilo de la imagen */
        .job-card-image {
            width: 100%;
            height: 200px; /* Ajuste de la altura */
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        /* Descripción */
        .job-card-description {
            margin-top: 10px;
            color: #555;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Detalles del trabajo */
        .job-card-details {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #777;
        }

        .job-card-details span {
            font-weight: bold;
            color: #219EBC;
        }

        /* Botón de aplicar */
        .btn-action {
            background-color: #219EBC;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 15px;
            display: block;
            width: 100%; /* Botón al 100% de la tarjeta */
            text-align: center;
        }

        .btn-action:hover {
            background-color: #1b82a6;
            transform: translateY(-2px);
        }

        .container h1 {
            margin-bottom: 40px;
            font-size: 2.5rem;
            color: #333;
            font-weight: bold;
            text-align: center;
            width: 100%; /* Asegura que el título ocupe todo el ancho */
        }

        /* Estilos para la paginación */
        .pagination {
            margin-top: 20px; /* Espaciado superior para la paginación */
            justify-content: center; /* Centrar los enlaces de paginación */
        }

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
    <h1>Publicaciones</h1>

    @foreach($jobOportunities as $joboportunity)
    @if($joboportunity->area_managers->users->status == 'active')
    <div class="job-card shadow-lg">
        <!-- Área con el círculo de la inicial -->
        <div class="job-card-area">
            <div class="job-card-avatar">
                {{ strtoupper(substr($joboportunity->area_managers->areas->name, 0, 1)) }}
            </div>
            {{ $joboportunity->area_managers->areas->name }}
        </div>

        <!-- Título -->
        <div class="job-card-title">{{ $joboportunity->title }}</div>

        <!-- Imagen destacada -->
        @if($joboportunity->image_path)
        <img src="{{ asset('storage/' . $joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="job-card-image">
        @else
        <div class="job-card-placeholder" style="background-color: #E0F2F1; padding: 50px; text-align: center; border-radius: 10px; color: #666;">
            Sin Imagen
        </div>
        @endif

        <!-- Descripción -->
        <div class="job-card-description">
            {{ $joboportunity->description }}
        </div>

        <!-- Detalles adicionales -->
        <div class="job-card-details">
            <div><span>Total Horas:</span> {{ $joboportunity->hours_validated }} horas</div>
            <div><span>Fecha de Inicio:</span> {{ $joboportunity->start_date }}</div>
        </div>

        <!-- Botón para aplicar -->
        <form action="{{ route('applications.store') }}" method="POST">
            @csrf
            <input type="hidden" name="job_opportunity_id" value="{{ $joboportunity->id }}">
            <button type="submit" class="btn btn-action">Aplicar</button>
        </form>
    </div>
    @endif
    @endforeach
</div>

{{-- Paginación fuera del contenedor de publicaciones --}}
<div class="d-flex justify-content-center mt-4">
    {{ $jobOportunities->links() }} {{-- Esto generará los enlaces de paginación --}}
</div>
@endsection

