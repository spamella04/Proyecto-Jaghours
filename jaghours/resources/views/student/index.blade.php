@extends('layouts.app')

@section('content')

<style>
    .table-container {
        padding: 1rem;
        border-radius: 8px;
        background-color: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        text-align: left;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    .table th {
        background-color: #343a40;
        color: #fff;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .btn-action {
        margin-right: 0.5rem;
    }

    .btn-create {
        background-color: #219EBC;
        border-color: #219EBC;
        color: #fff;
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

    .btn-danger {
        background-color: #DC3545;
        border-color: #DC3545;
        color: #fff;
    }

    .btn-action:hover {
        opacity: 0.8;
    }

    .btn-show-all {
        margin-left: 0.5rem;
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Listado de Estudiantes</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-lg btn-create">Crear nuevo registro de estudiante</a>
    </div>

    <form action="{{ route('students.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por cif, nombre o apellido..." value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-info">Buscar</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary btn-show-all">Mostrar todos</a>
            </div>
        </div>
    </form>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CIF</th>
                        <th>Nombre</th>
                        <th>Apellido</th>

                        <th>Estado</th>
                        <th>Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

