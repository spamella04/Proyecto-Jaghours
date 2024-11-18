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

        .btn-info {
        background-color: #17A2B8;
        border-color: #17A2B8;
        color: #fff;
    }
    </style>
    <script>
        function toggleDetails(element) {
            const details = element.querySelector('.applicant-details');
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
                element.classList.add('expanded');
            } else {
                details.style.display = 'none';
                element.classList.remove('expanded');
            }
        }
        // Esto es para deshabilitar el botón y mostrar un mensaje de carga
        function handleButtonClick(form) {
            const button = form.querySelector('button[type="submit"]');
            button.disabled = true;
            button.textContent = 'Procesando...';

        }
    </script>
</head>


<div class="container mt-4">
    <h1>Estudiantes que aplicaron a {{ $joboportunity->title }}</h1>

    <form action="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por cif, nombre o apellido..." value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-info">Buscar</button>
                <a href="{{ route('joboportunity.showapplicants', $joboportunity->id) }}" class="btn btn-secondary btn-show-all">Mostrar todos</a>
            </div>
        </div>
    </form>

    {{-- Renderizar la tabla de aplicaciones usando el decorador --}}
    {!! $applicationsTable !!} {{-- Contenido generado por el decorador correspondiente --}}
</div>
@endsection