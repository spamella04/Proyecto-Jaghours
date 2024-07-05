@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h3 class="mb-0">Detalles de la Solicitud</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('adminjobopportunities.update', $jobOpportunity->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label font-weight-bold">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $jobOpportunity->title }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label font-weight-bold">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ $jobOpportunity->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="area" class="form-label font-weight-bold">Área</label>
                            <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $jobOpportunity->area_managers->areas->name }}" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hours_validated" class="form-label font-weight-bold">Horas Convalidadas</label>
                            <input type="number" class="form-control @error('hours_validated') is-invalid @enderror" id="hours_validated" name="hours_validated" value="{{ $jobOpportunity->hours_validated }}" required>
                            @error('hours_validated')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="number_applicants" class="form-label font-weight-bold">Número de Aplicantes</label>
                            <input type="number" class="form-control @error('number_applicants') is-invalid @enderror" id="number_applicants" name="number_applicants" value="{{ $jobOpportunity->number_applicants }}" required>
                            @error('number_applicants')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="number_vacancies" class="form-label font-weight-bold">Número de Vacantes</label>
                            <input type="number" class="form-control @error('number_vacancies') is-invalid @enderror" id="number_vacancies" name="number_vacancies" value="{{ $jobOpportunity->number_vacancies }}" required>
                            @error('number_vacancies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label font-weight-bold">Fecha de Inicio</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ $jobOpportunity->start_date }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="requirements" class="form-label font-weight-bold">Requerimientos</label>
                            <input type="text" class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" value="{{ $jobOpportunity->requirements }}">
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-5">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                                <div class="col">
                                    <a href="{{ route('adminjobopportunities.publish', $jobOpportunity->id) }}" class="btn btn-primary">Publicar</a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('adminjobopportunities.reject', $jobOpportunity->id) }}" class="btn btn-danger">Rechazar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
