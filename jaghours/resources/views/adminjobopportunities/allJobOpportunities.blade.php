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

    .table th, .table td {
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


    /* Estilos de los filtros */
    .form-group input,
    .form-group select {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        width: 100%;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Contenedor de la búsqueda */
    .search-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .search-container .form-group {
        flex: 1;
    }

    

    .btn-info {
        background-color: #17A2B8;
        border-color: #17A2B8;
        color: #fff;
    }


    .btn-show-all {
        margin-left: 0.5rem;
    }

    .btn-warning {
        background-color: #FFC107;
        border-color: #FFC107;
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

        .btn-action {
        margin-right: 0.5rem;
    }

    .btn-action:hover {
        opacity: 0.8;
        background-color: #219EBC;
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

</style>

<div class="container py-5">

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="mb-4">
        <form method="GET" action="{{ route('adminjobopportunities.allJobOpportunities') }}">
        <h2 class="font-weight-bold">Listado de oportunidades creadas</h2>
            <div class="search-container">
                <!-- Campo de búsqueda por nombre -->
                <div class="form-group">
                    <input type="text" name="search_term" class="form-control" placeholder="Buscar por título de la oportunidad"
                        value="{{ request('search_term') }}">
                </div>

                <!-- Filtro de Área -->
                <div class="form-group">
                    <select name="area_id" class="form-control">
                        <option value="">Seleccione un área</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro de Estado -->
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">Seleccione un estado</option>
                        @foreach ($states as $state)
                            @if ($state != 'Solicitud') <!-- Excluir "Solicitud" -->
                                <option value="{{ $state }}" {{ request('status') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="mb-4">
                <button type="submit" class="btn btn-info">Buscar</button>
                <a href="{{ route('adminjobopportunities.allJobOpportunities') }}" class="btn btn-secondary btn-show-all">Mostrar todos</a>
            </div>
        </form>
    </div>

    <!-- Tabla de Oportunidades -->
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Área</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobOportunities as $opportunity)
                    <tr>
                        <td>{{ $opportunity->title }}</td>
                        <td>{{ $opportunity->area_managers->areas->name ?? 'N/A' }}</td>
                        <td>{{ $opportunity->status }}</td>
                        <td>
                            @if($opportunity->status != 'Inactivo' && $opportunity->status != 'Cerrado')
                        <a href="{{ route('adminjobopportunities.editJobOpportunities', $opportunity->id) }}" class="btn btn-editar btn-sm btn-action"> Editar </a>
                        <form action="{{ route('adminjobopportunities.inactive', $opportunity->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-estado-usuario btn-sm btn-action">Desactivar</button>
                            </form>
                           

                            @elseif($opportunity->status != 'Cerrado')
                            <form action="{{ route('adminjobopportunities.active', $opportunity->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-estado-usuario btn-sm btn-action">Activar</button>
                            </form>
                            @endif
                        

                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>  
</div> 

        <!-- Paginación con los parámetros de búsqueda -->

        <div class="mt-4 d-flex justify-content-center">
        {{ $jobOportunities->appends(['search_term' => request('search_term'), 'area_id' => request('area_id'), 'status' => request('status')])->links() }}
        </div>

    @endsection
