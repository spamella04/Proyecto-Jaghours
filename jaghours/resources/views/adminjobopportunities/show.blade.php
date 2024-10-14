@extends('layouts.app')

@section('content')

<style>
    .btn-action {
        margin-right: 0.5rem;
    }

    .btn-info {
        background-color: #17A2B8;
        border-color: #17A2B8;
        color: #fff;
    }

    .btn-warning {
        background-color: #FFC107;
        border-color: #FFC107;
        color: #fff;
    }

    .image-card {
        border: 1px solid #ddd;
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        background-color: #f8f9fa;
    }

    .image-card img {
        max-height: 150px; /* Limitar altura para que no se vea demasiado grande */
        max-width: 100%;
        border-radius: 15px;
        margin-bottom: 0.5rem;
    }

    .row > div {
        padding-bottom: 1rem; /* Espacio entre columnas */
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h3 class="mb-0">Detalles de la Solicitud</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('adminjobopportunities.update', $jobOpportunity->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
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
                            </div>

                            <div class="col-md-6">
                                <div class="image-card">
                                    @if($jobOpportunity->image_path)
                                        <img src="{{ asset($jobOpportunity->image_path) }}" alt="Imagen de la Solicitud" class="img-fluid">
                                        <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/*">
                                        <button type="button" class="btn btn-warning mt-2">Reemplazar</button>
                                    @else
                                        <p>No hay imagen disponible.</p>
                                        <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path" accept="image/*" required>
                                        <button type="button" class="btn btn-secondary mt-2">Agregar Imagen</button>
                                    @endif
                                    @error('image_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="area" class="form-label font-weight-bold">Área</label>
                                    <input type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ $jobOpportunity->area_managers->areas->name }}" required>
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="hours_validated" class="form-label font-weight-bold">Horas Convalidadas</label>
                                    <input type="number" class="form-control @error('hours_validated') is-invalid @enderror" id="hours_validated" name="hours_validated" value="{{ $jobOpportunity->hours_validated }}" required>
                                    @error('hours_validated')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="number_applicants" class="form-label font-weight-bold">Número de Aplicantes</label>
                                    <input type="number" class="form-control @error('number_applicants') is-invalid @enderror" id="number_applicants" name="number_applicants" value="{{ $jobOpportunity->number_applicants }}" required>
                                    @error('number_applicants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="number_vacancies" class="form-label font-weight-bold">Número de Vacantes</label>
                                    <input type="number" class="form-control @error('number_vacancies') is-invalid @enderror" id="number_vacancies" name="number_vacancies" value="{{ $jobOpportunity->number_vacancies }}" required>
                                    @error('number_vacancies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label font-weight-bold">Fecha de Inicio</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ $jobOpportunity->start_date }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="requirements" class="form-label font-weight-bold">Requerimientos</label>
                                    <input type="text" class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" value="{{ $jobOpportunity->requirements }}">
                                    @error('requirements')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-5">
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-warning btn-action">Guardar Cambios</button>
                                </div>
                                <div class="col">
                                    <a href="{{ route('adminjobopportunities.publish', $jobOpportunity->id) }}" class="btn btn-info btn-action">Publicar</a>
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
