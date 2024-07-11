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
        }

        .job-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .job-card-title {
            font-weight: bold;
            font-size: 1.2em;
        }

        .job-card-area {
            color: gray;
            font-size: 0.9em;
        }

        .job-card-details {
            margin-top: 10px;
            color: gray;
            font-size: 0.9em;
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
    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'areamanager')
        <h1 class="">Listado de Trabajos</h1>

        @foreach($jobs as $job)
            <div class="job-card">
                <div class="d-flex align-items-center">
                    <div>
                        <div class="job-card-title">{{ $job->job_opportunity->title }}</div>
                        <div class="job-card-area">
                            <span>{{ $job->job_opportunity->area_managers->areas->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="job-card-details mt-3">
                    <span class="fw-bold" style="color:#219EBC;">Fecha:</span>
                    <span>{{ $job->job_opportunity->start_date }}</span>
                    <br>
                    <span class="fw-bold" style="color:#219EBC;">Total Horas Convalidables:</span>
                    <span>{{ $job->job_opportunity->hours_validated }} horas</span>
                    <br>
                    <span class="fw-bold" style="color:#219EBC;">Estudiante:</span>
                    <span>{{ $job->student->user->name }} {{ $job->student->user->lastname }}</span>
                    <br>
                    <span class="fw-bold" style="color:#219EBC;">CIF:</span>
                    <span>{{ $job->student->user->cif }}</span>
                </div>
                <div class="job-card-hours mt-3">
                    @php
                        $total_hours = $job->hourRecords->sum('hours_worked');
                    @endphp

                    @if($total_hours >= $job->job_opportunity->hours_validated)
                        <span class="text-success fw-bold">Trabajo Convalidado</span>
                    @else
                        <a href="{{ route('hourrecords.create', $job->id) }}" class="btn">Convalidar Horas</a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif


</div>
@endsection
