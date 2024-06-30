@extends('layouts.app')


@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Listado de Representantes de Area</h2>
        <a href="{{ route('areamanagers.create') }}" class="btn btn-primary btn-lg">Crear nuevo registro de representante</a>
    </div>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">CIF</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Area</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @if($user->role == 'areamanager')
                                <tr>
                                    <td>{{ $user->cif }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->area_manager->areas->name}}</td>
                                    <td class="d-flex">
                                        <a href="{{ route('areamanagers.edit', $user->id) }}" class="btn btn-warning btn-sm mr-2">Editar</a>
                                        <form action="{{ route('areamanagers.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection