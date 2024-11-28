@extends('layouts.app')

@section('content')
<head>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap; 
            justify-content: space-between; 
            margin-top: 20px;
            padding: 0 15px; 
        }

        .job-card {
            flex: 0 0 48%; 
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-bottom: 30px; 
        }

        .job-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

      
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

      
        .job-card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

  
        .job-card-image {
            width: 100%;
            height: 220px; 
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }
        .job-card-image:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .job-card-placeholder {
            width: 100%;
            height: 200px;
            background-color: #E0F2F1;
            border: 1px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #aaa;
            font-size: 1.5rem;
            text-align: center;
            margin-top: 10px;
            border-radius: 10px;
            position: relative;
        }

        .job-card-placeholder:before {
            content: "Sin Imagen";
            position: absolute;
            font-size: 1rem;
            color: #666;
        }
        .job-card-description {
            margin-top: 10px;
            color: #555;
            font-size: 1rem;
            line-height: 1.5;
        }

    
        .job-card-details {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #777;
        }

        .job-card-details span {
            font-weight: bold;
            color: #219EBC;
        }

        
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
            width: 100%; 
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
            width: 100%; 
        }

        
        .pagination {
            margin-top: 20px; 
            justify-content: center; 
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

         
             .filter-container {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f7f7f7;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .filter-container select {
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 10px;
            font-size: 1rem;
        }

        .filter-container button {
            padding: 10px 20px;
            background-color: #219EBC;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .filter-container button:hover {
            background-color: #1b82a6;
        }
    </style>
</head>

<div class="container mt-4">
    <h1>Publicaciones</h1>

    <!-- Filtro por área -->
    <div class="filter-container">
        <form action="{{ route('joboportunity.indexStudent') }}" method="GET">
            <select name="area" id="area">
                <option value="">Seleccionar área</option>
                @foreach($areas as $area)
                    <option value="{{ $area->name }}" {{ request('area') == $area->name ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <!-- Tarjetas de las oportunidades -->
    <div class="container">
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
                <img src="{{ asset($joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="job-card-image" data-bs-toggle="modal" data-bs-target="#imageModal{{ $joboportunity->id }}">
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
                    <div><span>Total horas convalidadas:</span> {{ $joboportunity->hours_validated }} horas</div>
                    <div><span>Fecha de inicio:</span> {{ $joboportunity->start_date }}</div>
                </div>

                <!-- Botón para aplicar -->
                <form action="{{ route('applications.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_opportunity_id" value="{{ $joboportunity->id }}">
                    <button type="submit" class="btn btn-action">Aplicar</button>
                </form>
            </div>

            <div class="modal fade" id="imageModal{{ $joboportunity->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $joboportunity->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel{{ $joboportunity->id }}">{{ $joboportunity->title }}</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"> <img src="{{ asset($joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="img-fluid"> </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    {{-- Paginación fuera del contenedor de publicaciones --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $jobOportunities->links() }} {{-- Esto generará los enlaces de paginación --}}
    </div>
</div>
@endsection

