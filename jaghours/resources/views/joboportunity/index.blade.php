@extends('layouts.app')
@section('content')

<div class="container mt-4">
    <h1 class="text-center">Solicitudes</h1>
    <a href="{{ route('joboportunity.create') }}" class="btn btn-primary mb-3">Crear Nueva Solicitud</a>
    
    @foreach($jobOportunities as $joboportunity)
    <div class="job-card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="d-flex align-items-center">
           
            <div>
                <div class="job-card-title fw-bold">{{ $joboportunity->title }}</div>
                <div class="job-card-date">{{ $joboportunity->created_at }}</div>
            </div>
        </div>
        <div class="job-card-description mt-3">
            {{ $joboportunity->description }}
        </div>
        <div class="job-card-details mt-3">
            <span class="fw-bold">Total Horas Convalidadas: {{ $joboportunity->hours_validated }} horas</span>
            <span class="fw-bold">Fecha de Inicio: {{ $joboportunity->start_date }}</span>
        </div>
    </div>
    @endforeach
</div>
@endsection