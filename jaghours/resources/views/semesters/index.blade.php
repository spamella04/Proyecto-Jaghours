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
    .btn-editar {
        background-color: #61929b;
        border-color: #61929b;
        color: #fff;
    }

    .btn-estado-usuario{
        background-color: #669bbc;
        border-color: #669bbc;
        color: #fff;
    }
    .btn-action:hover {
        opacity: 0.8;
        background-color: #219EBC;
        color: #fff;
       
    }
    /* Diseño paginacion*/
    
    .pagination .page-link {
            color: #219EBC;
            background-color: white;
            border: 1px solid #ddd;
        }

        .pagination .page-link:hover {
            background-color: #f1f1f1;
        }

        .pagination .page-item.active .page-link {
            background-color: #219EBC;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
        }

</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Listado de Semestres</h2>
        <a href="{{ route('semesters.create') }}" class="btn btn-primary btn-lg btn-create">Crear nuevo semestre</a>
    </div>

    <form action="{{ route('semesters.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..." value="{{ $search }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-info">Buscar</button>
                <a href="{{ route('semesters.index') }}" class="btn btn-secondary btn-show-all">Mostrar todos</a>
            </div>
        </div>
    </form>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Finalización</th>
                            <th>Horas Requeridas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semesters as $semester)
                            <tr>
                                <td>{{ $semester->name }}</td>
                                <td>{{ $semester->start_date }}</td>
                                <td>{{ $semester->end_date }}</td>
                                <td>{{ $semester->hours_required }}</td>

                                @if($semester->status == 'active')
                                    <td>Activo</td>
                                    <td>
                                        <a href="{{ route('semesters.edit', $semester->id) }}" class="btn btn-editar btn-sm btn-action">Editar</a>
                                        <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-estado-usuario btn-sm btn-action">Desactivar</button>
                                        </form>
                                    </td>
                                @else
                                    <td>Inactivo</td>
                                    <td>
                                        <form action="{{ route('semesters.notdestroy', $semester->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-estado-usuario btn-sm btn-action">Activar</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No se encontraron resultados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Navegación de paginación -->
<div class="mt-4 d-flex justify-content-center">
{{ $semesters->appends(request()->except('page'))->links() }}
</div>

@endsection
