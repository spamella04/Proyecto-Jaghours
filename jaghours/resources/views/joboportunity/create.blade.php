@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-4">
                    <h3 class="mb-0">Crear una Nueva Publicación</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('joboportunity.store') }}" method="POST" enctype="multipart/form-data"> <!-- Agregar enctype para permitir la subida de archivos -->
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="form-label font-weight-bold">Título de la Solicitud</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-group">
                                <label for="match" class="form-label font-weight-bold">¿Es un partido?</label>
                                <input type="checkbox" id="match" name="match" value="1" {{ old('match', $joboportunity->match ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label font-weight-bold">Descripción de la Solicitud</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
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
                                <label for="number_applicants" class="form-label font-weight-bold">Número de Aplicantes</label>
                                <input type="number" class="form-control @error('number_applicants') is-invalid @enderror" id="number_applicants" name="number_applicants" value="{{ old('number_applicants') }}" min="1" required>
                                @error('number_applicants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="number_vacancies" class="form-label font-weight-bold">Número de Vacantes</label>
                                <input type="number" class="form-control @error('number_vacancies') is-invalid @enderror" id="number_vacancies" name="number_vacancies" value="{{ old('number_vacancies') }}" min="1" required>
                                @error('number_vacancies')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="requirements" class="form-label font-weight-bold">Requerimientos</label>
                                <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="4" required>{{ old('requirements') }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label font-weight-bold">Subir Imagen</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
