@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-weight-bold">Listado de Carreras</h2>
        <a href="{{route('degrees.create')}}" class="btn btn-primary btn-lg">Crear nueva carrera</a>
    </div>

    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($degrees as $degree)
                        <tr>
                            <td>{{ $degree->code }}</td>
                            <td>{{ $degree->name }}</td>
                            <td class="d-flex">
                                <a href="{{route ('degrees.edit', $degree->id)}}" class="btn btn-warning btn-sm mr-2">Editar</a>
                                <form action="{{route('degrees.destroy', $degree->id)}}" method="POST" class="d-inline">
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
@endsection