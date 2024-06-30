@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Listado de Areas</h2>
        <a href="{{ route('areas.create') }}" class="btn btn-primary btn-lg">Crear nueva area</a>
    </div>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($areas as $area)
                                <tr>
                                    <td>{{ $area->code }}</td>
                                    <td>{{ $area->name }}</td>
                                    <td>{{ $area->description }}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-warning btn-sm mr-2">Editar</a>
                                        <form action="{{ route('areas.destroy', $area->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection