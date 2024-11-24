@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-4">
                    <h3 class="mb-0">Crear Nueva Oportunidad de Trabajo</h3>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('directjobopportunity.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                       
                        <div class="mb-4">
                            <label for="title" class="form-label font-weight-bold">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                     
                        <div class="mb-4">
                            <label for="description" class="form-label font-weight-bold">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="hours_validated" class="form-label font-weight-bold">Horas Convalidadas</label>
                            <input type="number" class="form-control @error('hours_validated') is-invalid @enderror" id="hours_validated" name="hours_validated" value="{{ old('hours_validated') }}" min="1" required>
                            @error('hours_validated')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                     
                        <div class="mb-4">
                            <label for="image" class="form-label font-weight-bold">Imagen</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="background-color: #219EBC; border-color: #219EBC;">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

