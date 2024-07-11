@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h3 class="mb-0">Ingrese la información de la Solicitud</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('joboportunity.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label font-weight-bold">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label font-weight-bold">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="hours_validated" class="form-label font-weight-bold">Horas Convalidadas</label>
                                <input type="number" class="form-control @error('hours_validated') is-invalid @enderror" id="hours_validated" name="hours_validated" value="{{ old('hours_validated') }}" min="1" required>
                                @error('hours_validated')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="start_date" class="form-label font-weight-bold">Fecha de Inicio</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="number_applicants" class="form-label font-weight-bold">Numero de aplicantes</label>
                                <input type="number" class="form-control @error('number_applicants') is-invalid @enderror" id="number_applicants" name="number_applicants" value="{{ old('number_applicants') }}" min="1" required>
                                @error('number_applicants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="number_vacancies" class="form-label font-weight-bold">Numero de Vacantes</label>
                                <input type="number" class="form-control @error('number_vacancies') is-invalid @enderror" id="number_vacancies" name="number_vacancies" value="{{ old('number_vacancies') }}" min="1" required>
                                @error('number_vacancies')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="requirements" class="form-label font-weight-bold">Requerimientos</label>
                                <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements"  required>{{ old('requirements') }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="background-color: #219EBC; border-color: #219EBC;">Crear Solicitud</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
