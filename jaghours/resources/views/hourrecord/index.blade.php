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
        

    </style>
</head>
<div class="container mt-4">
    @if(Auth::user()->role == 'admin')
        <h1 class="text-center">Listado de Trabajos</h1>

        @foreach($jobs as $job)
            
                <div class="job-card shadow-lg p-3 mb-5 bg-white rounded"
                    style="word-wrap:break-word; overflow-wrap: break-word;">
                    <div class="d-flex align-items-center">

                        <div>
                            <div class="job-card-title fw-bold fs-4">{{ $job->job_opportunity->title }}</div>
                            <div class="job-card-area mt-1">
                                <span class="fw-bold"
                                    style="color:gray;">{{ $job->job_opportunity->area_managers->areas->name }}</span>
                            </div>
                           
                        </div>
                    </div>
                    <div class="job-card-details mt-3">
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Fecha:</span>
                        <span class="fw-light" style="color:gray;">{{ $job->job_opportunity->start_date }}</span>
                        <br>
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Total Horas
                            Convalidables:</span>
                        <span class="fw-light" style="color:gray;"> {{ $job->job_opportunity->hours_validated }} horas</span>
                        <br>
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Estudiante:</span>
                        <span class="fw-light" style="color:gray;"> {{ $job->student->user->name }} {{ $job->student->user->lastname }}</span>
                        <br>
                        <span class="fw-bold" style="font:10px; color:#219EBC; font-weight:500;">Cif:</span>
                        <span class="fw-light" style="color:gray;">{{ $job->student->user->cif}}</span>
                        
                    </div>
                    <div class="job-card-hours mt-3">
                    <a href="{{ route('hourrecords.create', $job->id) }}" class="btn btn-info btn-sm btn-action ">Convalidar Horas</a>
                    </div>
                </div>
            
        @endforeach
    @endif


</div>
@endsection
