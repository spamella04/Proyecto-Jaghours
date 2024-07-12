@extends('layouts.app')

@section('content')
<head>
    <style>
        .job-card {
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .job-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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
            margin-bottom: 5px;
            color: #333;
        }

        .job-card-area {
            color: #666;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .job-card-description {
            margin-top: 15px;
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
        }

        .btn-action:hover {
            background-color: #1b82a6;
            transform: translateY(-2px);
        }

        .container h1 {
            margin-bottom: 30px;
            font-size: 2rem;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<div class="container mt-4">
    <h1 class="">Publicaciones</h1>

    @foreach($jobOportunities as $joboportunity)
    @if($joboportunity->area_managers->users->status=='active')
    <div class="job-card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="d-flex align-items-center">
            <div class="job-card-avatar">
                {{ strtoupper(substr($joboportunity->area_managers->areas->name, 0, 1)) }}
            </div>
            <div>
                <div class="job-card-title">{{ $joboportunity->title }}</div>
                <div class="job-card-area">
                    {{ $joboportunity->area_managers->areas->name }}
                </div>
            </div>
        </div>
        <div class="job-card-description mt-3">
            {{ $joboportunity->description }}
        </div>
        <div class="job-card-details mt-3">
            <div><span>Total Horas Convalidadas:</span> {{ $joboportunity->hours_validated }} horas</div>
            <div><span>Fecha de Inicio:</span> {{ $joboportunity->start_date }}</div>
        </div>
        <div class="d-flex justify-content-end align-items-center mt-3">
            <div class="job-card-applicants">
                <form action="{{ route('applications.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="job_opportunity_id" value="{{ $joboportunity->id }}">
                    <button type="submit" class="btn btn-action">Aplicar</button>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection
