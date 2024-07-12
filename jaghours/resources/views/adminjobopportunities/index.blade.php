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
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Listado de Solicitudes</h2>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Área</th>
                        <th>Responsable Area</th>
                        <th>Horas Convalidadas</th>
                        <th>Fecha de Inicio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobOpportunities as $joboportunity)
                    <tr>
                        <td>{{ $joboportunity->title }}</td>
                        <td>{{ $joboportunity->area_managers->areas->name }}</td>
                        @if($joboportunity->area_managers->users->status=='active')
                            <td>Activo</td>
                        @endif
                        @if($joboportunity->area_managers->users->status=='inactive')
                            <td>Inactivo</td>
                        @endif
                        <td>{{ $joboportunity->hours_validated }}</td>
                        <td>{{ $joboportunity->start_date }}</td>
                        <td>
                            <a href="{{ route('adminjobopportunities.show', $joboportunity->id) }}" class="btn btn-info btn-sm btn-action">Ver</a>
                            <form action="{{ route('adminjobopportunities.destroy', $joboportunity->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-action">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
