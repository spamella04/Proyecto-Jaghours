@extends('layouts.app')

@section('content')

<head>
    <style>
        .custom-badge {
            display: inline-block;
            padding: 0.25em 0.5em;
            background-color: #219EBC;
            color: #fff; 
            border-radius: 0.25rem; /* Bordes redondeados */
        }
        .job-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .job-card-header {
            display: flex;
            align-items: center;
        }
        .job-card-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            background-color: #219EBC; /* Puedes personalizar este color */
        }
        .job-card-title {
            font-weight: bold;
            font-size: 1.2em;
        }
        .job-card-area {
            color: gray;
            font-size: 0.9em;
        }
        .job-card-description {
            margin-top: 10px;
            color: #333;
        }
        .job-card-details {
            margin-top: 10px;
            color: gray;
            font-size: 0.9em;
        }
        .job-card-apply {
            margin-top: 15px;
            text-align: right;
        }
        .job-card-apply p {
            color: #219EBC;
            font-weight: bold;
        }
    </style>
</head>

<div class="container mt-4">
    <h1 class="">Mis Postulaciones</h1>

    @if($applications->isEmpty())
        <p class="text-center">No tienes Postulaciones registradas.</p>
    @else
        <div class="row">
            @foreach($applications as $application)
                <div class="col-md-6 mb-4">
                    <div class="job-card shadow-lg p-3 mb-5 bg-white rounded">
                        <div class="job-card-header">
                            <div class="job-card-avatar">
                                {{ substr($application->job_opportunities->area_managers->areas->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="job-card-title">{{ $application->job_opportunities->title }}</div>
                                <div class="job-card-area">
                                    {{ $application->job_opportunities->area_managers->areas->name }}
                                </div>
                            </div>
                        </div>
                        <div class="job-card-description mt-3">
                            {{ $application->job_opportunities->description }}
                        </div>
                        <div class="job-card-details mt-3">
                            <div><span class="fw-bold" style="color:#219EBC;">Total Horas Convalidadas:</span> {{ $application->job_opportunities->hours_validated }} horas</div>
                            <div><span class="fw-bold" style="color:#219EBC;">Fecha de Inicio:</span> {{ $application->job_opportunities->start_date }}</div>
                        </div>
                        <div class="job-card-apply mt-3">
                            <p>{{ $application->status }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
