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
            margin-bottom: 20px;
            padding: 20px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            transition: transform 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
        }

        .job-card-title {
            font-size: 1.75em;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        .job-card-area,
        .job-card-date,
        .job-card-details span,
        .job-card-status span {
            font-size: 0.9em;
            color: #555;
        }

        .job-card-description {
            margin-top: 15px;
            margin-bottom: 15px;
            color: #444;
            line-height: 1.5;
        }

        .job-card-applicants {
            margin-top: 20px;
        }

        .applicant-card {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .applicant-card:hover {
            background-color: #e9f5fb;
        }

        .applicant-card-header {
            display: flex;
            flex-direction: column;
            margin-left: 10px;
        }

        .applicant-card .details {
            display: flex;
            flex-direction: row;
            gap: 0.5rem;
        }

        .applicant-card h5 {
            margin: 0;
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
        }

        .applicant-card button {
            background-color: #219EBC;
            border: none;
            padding: 8px 12px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .applicant-card button:hover {
            background-color: #17699E;
        }

        .applicant-details {
            display: none;
            padding: 10px;
            border-top: 1px solid #ddd;
            margin-top: 10px;
            background-color: #f1f1f1;
            border-radius: 0 0 10px 10px;
        }

        .expanded .applicant-card-header {
            margin-bottom: 10px;
            margin-left: 10px;
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
            margin-top: 15px;
            text-align: right;
            transition: background-color 0.3s ease;
        }

        .job-card-applicants a.btn:hover {
            background-color: #17699E;
        }
    </style>
    <script>
        function toggleDetails(element) {
            const details = element.querySelector('.applicant-details');
            const button = element.querySelector('button');
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
                element.classList.add('expanded');
            } else {
                details.style.display = 'none';
                element.classList.remove('expanded');
            }
        }
    </script>
</head>

<div class="container mt-4">
   
        <h1 class="" style="color: #333; font-weight: bold;">Aplicantes</h1>
        <div class="job-card shadow-lg p-3 mb-5 bg-white rounded">
            <div class="d-flex align-items-center">
                <div>
                    <div class="job-card-title">{{ $joboportunity->title }}</div>
                    <div class="job-card-area mt-1">
                        <span class="fw-bold" style="color:gray;">{{ $joboportunity->area_managers->areas->name }}</span>
                    </div>
                </div>
            </div>
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

            <div class="job-card-applicants mt-3">
                <h5 class="fw-bold" style="color:#219EBC;">Estudiantes que aplicaron:</h5>
                @if($joboportunity->applications->isEmpty())
                    <p style="color:gray;">No hay estudiantes que hayan aplicado aún.</p>
                @else
                    @php
                        $acceptedCount = $joboportunity->applications()->where('status', 'Aceptado')->count();
                    @endphp

                    @foreach($joboportunity->applications as $application)
                        <div class="applicant-card" onclick="toggleDetails(this)">
                            <div class="applicant-card-header">
                                <div class="details">
                                    <p style="font-weight: bold;">Nombre:</p>
                                    <p style="color:gray;">{{ $application->decoratedStudent->getFullName()}}</p>
                                </div>
                                <div class="details">
                                    <p style="font-weight: bold;">CIF:</p>
                                    <p style="color:gray;">{{ $application->student->user->cif }}</p>
                                </div>
                            </div>
                            <div class="applicant-details">
                                <div class="details">
                                    <p style="font-weight: bold;">Habilidades:</p>
                                   
                                </div>
                                <div class="details">
                                    <p style="color:gray;">{{ $application->decoratedStudent->getFormattedSkills() }}</p>
                                </div>
                                <div class="details">
                                    <p style="font-weight: bold;">Email:</p>
                                    <p style="color:gray;">{{ $application->student->user->email }}</p>
                                </div>
                                <div class="details">
                                    <p style="font-weight: bold;">Teléfono:</p>
                                    <p style="color:gray;">{{ $application->student->user->phone }}</p>
                                </div>
                                <div class="details">
                                    <p style="font-weight: bold;">Fecha de Aplicación:</p>
                                    <p style="color:gray;">{{ $application->created_at }}</p>
                                </div>
                            </div>
                            @if ($application->status == 'Aceptado')
                                <span class="fw-bold text-success">Aceptado</span>
                            @endif
                            @if ($application->status == 'No Aceptado')
                                <span class="fw-bold text-danger">No Aceptado</span>
                            @endif
                            @if($application->status == 'Pendiente')
                                @if ($acceptedCount >= $joboportunity->number_vacancies)
                                    <button type="button" class="btn btn-info btn-sm btn-action" disabled>Aceptar Aplicantes</button>
                                @else
                                    <form method="POST" action="{{ route('job.store') }}">
                                        @csrf
                                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                                        <button type="submit" class="btn btn-info btn-sm btn-action">Aceptar Aplicantes</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    
</div>

@endsection
