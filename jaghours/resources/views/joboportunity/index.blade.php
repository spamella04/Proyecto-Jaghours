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
        .job-card-applicants {
            margin-top: 15px;
            text-align: right;
        }
        .job-card-applicants a.btn {
            background-color: #219EBC;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }
        .job-card-applicants a.btn:hover {
            background-color: #17699E;
        }
        

    </style>
</head>
<div class="container mt-4">
    @if(Auth::user()->role == 'areamanager')
        <h1 class="text-center">Solicitudes</h1>
        <a href="{{ route('joboportunity.create') }}" class="btn btn-primary mb-3">Crear Nueva
            Solicitud</a>
        @foreach($jobOportunities as $joboportunity)
            <div class="job-card shadow-lg p-3 mb-5 bg-white rounded"
                style="word-wrap:break-word; overflow-wrap: break-word;">
                <div class="d-flex align-items-center">

                    <div>
                        <div class="job-card-title fw-bold fs-4">{{ $joboportunity->title }}</div>
                        <div class="job-card-area mt-1">
                            <span class="fw-bold"
                                style="color:gray;">{{ $joboportunity->area_managers->areas->name }}</span>
                        </div>
                        <div class="job-card-date" style="font:10px; color:#219EBC; font-weight:500;">Fecha 
                            solicitado: {{ $joboportunity->created_at }}</div>
                    </div>
                </div>
                <div class="job-card-description mt-3">
                    {{ $joboportunity->description }}
                </div>
                <div class="job-card-details mt-3">
                    <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Total Horas
                        Convalidadas:</span>
                    <span class="fw-light" style="color:gray;"> {{ $joboportunity->hours_validated }} horas</span>
                    <br>
                    <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Fecha de Inicio:</span>
                    <span class="fw-light" style="color:gray;">{{ $joboportunity->start_date }}</span>

                </div>
                <div class="job-card-status mt-3">
                    <span class="fw-bold">
                        <span class="custom-badge">{{ $joboportunity->status }}</span>
                    </span>
                </div>
            </div>
        @endforeach

    @endif

    @if(Auth::user()->role == 'admin')
        <h1 class="text-center">Publicaciones</h1>

        @foreach($jobOportunities as $joboportunity)
            @if($joboportunity->status == 'Publicado')
                <div class="job-card shadow-lg p-3 mb-5 bg-white rounded"
                    style="word-wrap:break-word; overflow-wrap: break-word;">
                    <div class="d-flex align-items-center">

                        <div>
                            <div class="job-card-title fw-bold fs-4">{{ $joboportunity->title }}</div>
                            <div class="job-card-area mt-1">
                                <span class="fw-bold"
                                    style="color:gray;">{{ $joboportunity->area_managers->areas->name }}</span>
                            </div>
                           
                        </div>
                    </div>
                    <div class="job-card-description mt-3">
                        {{ $joboportunity->description }}
                    </div>
                    <div class="job-card-details mt-3">
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Total Horas
                            Convalidadas:</span>
                        <span class="fw-light" style="color:gray;"> {{ $joboportunity->hours_validated }} horas</span>
                        <br>
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Fecha de Inicio:</span>
                        <span class="fw-light" style="color:gray;">{{ $joboportunity->start_date }}</span>

                    </div>
                    <div class="job-card-status mt-3">
                        <span class="fw-bold">
                            <span class="custom-badge">{{ $joboportunity->status }}</span>
                        </span>
                    </div>
                    <div class="job-card-applicants mt-3">
                        <a href="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action ">Ver Estudiantes</a>
                    </div>
                </div>
            @endif
        @endforeach
    @endif


</div>
@endsection
