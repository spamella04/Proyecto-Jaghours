@extends('layouts.app')

@section('content')

<style>

.center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
        }

        .center-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
        }

        .job-card {
            width: 100%;
            margin-bottom: 20px;
            box-sizing: border-box;
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
            font-size: 1.75rem;
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
            font-size: 1rem;
            line-height: 1.8;
        }

        .job-card-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 15px;
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

<div class="container mt-4">
    @if(Auth::user()->role == 'areamanager')
        <h1 class="">Publicaciones</h1>
        @foreach($jobOportunities as $joboportunity)
            @if($joboportunity->status == 'Publicado' && $joboportunity->match == 0)
            <div class="col-md-6 mb-4">
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
                    <img src="{{ asset($joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="job-card-image" data-bs-toggle="modal" data-bs-target="#imageModal{{ $joboportunity->id }}">
                    @else
                <div class="job-card-placeholder">
                    Sin Imagen
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
                            <a href="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action">Ver Aplicantes</a>
                        </div>
                    </div>
                </div>
</div>
<div class="modal fade" id="imageModal{{ $joboportunity->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $joboportunity->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel{{ $joboportunity->id }}">{{ $joboportunity->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset($joboportunity->image_path) }}" alt="Imagen de {{ $joboportunity->title }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
            @endif
        @endforeach
    @endif

   

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $jobOportunities->links() }} {{-- Esto generará los enlaces de paginación usando Bootstrap --}}
    </div>

</div>




@endsection
