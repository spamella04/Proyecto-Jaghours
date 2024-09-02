@extends('layouts.app')

@section('content')

<style>
    /* Estilos consistentes con el diseño de AreaManager */
    .search-container {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
    }

    .search-input {
        width: 65%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .search-button,
    .reset-button {
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
    }

    .search-button {
        background-color: #219EBC;
    }

    .search-button:hover {
        background-color: #1b7f9c;
    }

    .reset-button {
        background-color: #6c757d;
    }

    .reset-button:hover {
        background-color: #5a6268;
    }

    .table-container {
        padding: 1rem;
        border-radius: 8px;
        background-color: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        <h2 class="font-weight-bold">Listado de Áreas</h2>
        <a href="{{ route('areas.create') }}" class="btn btn-primary btn-lg btn-create">Crear nueva
            área</a>
    </div>

    <div class="search-container">
        <form action="{{ route('areas.index') }}" method="GET" class="w-100 d-flex">
            <input type="text" name="search" class="form-control search-input" placeholder="Buscar por código o nombre" value="{{ request('search') }}">
            <button class="btn search-button" type="submit">Buscar</button>
            <a href="{{ route('areas.index') }}" class="btn reset-button">Mostrar Todos</a>
        </form>
    </div>

    <div class="table-container">

                            <tr>
                                <td>{{ $area->code }}</td>
                                <td>{{ $area->name }}</td>
                                <td>{{ $area->description }}</td>

    </div>
</div>

@endsection
