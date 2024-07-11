@extends('layouts.app')

@section('content')

<style>
    .job-card {
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .job-card-area {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .job-card-date {
        color: #219EBC;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .job-card-description {
        margin-top: 10px;
        color: #333;
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
        background-color: #E0F2F1; /* Fondo más claro */
        color: #219EBC; /* Letras en color #219EBC */
        border-radius: 0.25rem;
        font-size: 0.8rem;
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

</style>

<div class="container mt-4">
    @if(Auth::user()->role == 'areamanager')
        <h1 class="">Publicaciones</h1>

        @foreach($jobOportunities as $joboportunity)
            @if($joboportunity->status == 'Publicado')
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
                        </div>
                    </div>
                    <div class="job-card-description mt-3">
                        {{ $joboportunity->description }}
                    </div>
                    <div class="job-card-details mt-3">
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Total Horas Convalidadas:</span>
                        <span class="fw-light" style="color:gray;"> {{ $joboportunity->hours_validated }} horas</span>
                        <br>
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Fecha de Inicio:</span>
                        <span class="fw-light" style="color:gray;">{{ $joboportunity->start_date }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="job-card-status">
                            <span class="custom-badge">{{ $joboportunity->status }}</span>
                        </div>
                        <div class="job-card-applicants">
                            <a href="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action">Ver Estudiantes</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

</div>
@endsection