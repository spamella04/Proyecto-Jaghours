@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <h2 class="card-title mb-4 font-weight-bold text-center">Perfil del Estudiante</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Nombre:</label>
                        <p class="form-control-static">{{ $user->name }} {{ $user->lastname }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Correo:</label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Teléfono:</label>
                        <p class="form-control-static">{{ $user->phone }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">CIF:</label>
                        <p class="form-control-static">{{ $user->cif }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Curso:</label>
                        <p class="form-control-static">{{ $user->student->degree->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Habilidades:</label>
                        <p class="form-control-static">{{ $user->student->skills }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <a href="{{ route('students.index') }}" class="btn btn-primary float-end">Regresar</a>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@endsection
