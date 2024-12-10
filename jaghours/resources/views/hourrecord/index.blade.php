@extends('layouts.app')

@section('content')

<head>
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
            height: 300px;
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
            content: "";
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
            background-color: #E0F2F1;
            color: #219EBC;
            border-radius: 0.25rem;
            font-size: 0.9rem;
        }

        .btn-action {
            background-color: #17A2B8;
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
            background-color: #41c4d9;
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

        .btn-primary {
            background-color: #17A2B8;
            border-color: #17A2B8;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #41c4d9;
            border-color: #17A2B8;
        }

        .btn-celeste {
            background-color: #5baede;
            border-color: #5baede;
            color: #fff;
            font-weight: bold;
        }

        .btn-celeste:hover {
            background-color: #4aa3c5;
            color: #fff;
            border-color: #4aa3c5;
        }

        .btn-celeste:focus,
        .btn-celeste:active {
            background-color: #4aa3c5;
            border-color: #4aa3c5;
            color: #fff;
            box-shadow: none;
        }
    </style>
</head>

<div class="container mt-4">
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'areamanager')
    <h1 class="">Trabajos a convalidar</h1>

    <form action="{{ route('job.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="year" class="form-label">Año</label>
                <select name="year" id="year" class="form-select">
                    <!-- Opción para mostrar todos los años -->
                    <option value="all" {{ $year === 'all' ? 'selected' : '' }}>Todos</option>
                    @foreach(range(2020, now()->year) as $yearOption)
                    <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="month" class="form-label">Mes</label>
                <select name="month" id="month" class="form-select">
                    <!-- Opción para mostrar todos los meses -->
                    <option value="all" {{ $month === 'all' ? 'selected' : '' }}>Todos</option>
                    @foreach(range(1, 12) as $monthOption)
                    <option value="{{ $monthOption }}" {{ $month == $monthOption ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::createFromDate(null, $monthOption, 1)->format('F') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mt-2" style="border: none; width: 100%;">Filtrar</button>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('job.index') }}" class="btn btn-secondary mt-2" style="width: 100%;">Mostrar todas</a>
            </div>
        </div>
    </form>

    @if(Auth::user()->role === 'admin')

    <a href="{{ route('directjobopportunity.directEntry') }}" class="btn btn-action">
        Nuevo registro de horas
    </a>
    <!-- Mensajes de éxito o error en la parte superior -->
    <div class="alert-container mb-4">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @elseif ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    @endif

    <div class="row mt-4">
        @foreach($jobOpportunities as $joboportunity)
        <div class="col-md-6 mb-4"> <!-- Cada tarjeta ocupa el 50% de la fila en pantallas medianas y más grandes -->
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
                    
                </div>
                @endif
                <div class="job-card-description mt-3">
                    {{ $joboportunity->description }}
                </div>
                <div class="job-card-details mt-3">
                    <span class="fw-bold" style="color:#219EBC;">Total horas convalidadas:</span>
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
                        @if($joboportunity->match == 1)
                        <a href="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action">Convalidar</a>
                        @else
                        <a href="{{ route('jobs.students', encrypt($joboportunity->id)) }}" class="btn btn-info btn-sm btn-action">Convalidar</a>
                        @endif
                    </div>
                </div>
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
        </div>
        @endforeach
    </div>

    @endif

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $jobOpportunities->appends(request()->except('page'))->links() }}
    </div>



</div>

@endsection