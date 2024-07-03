@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class= "font-weight-bold">Listado de Semestres</h2>
        <a href="{{ route('semesters.create') }}" class="btn btn-primary btn-lg">Crear nuevo semestre</a>
    </div>

    <div class= "card shadow-sm rounded-lg">
        <div class="card-pain">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de Inicio</th>
                            <th scope="col">Fecha de Finalizacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semesters as $semester)
                            <tr>
                                <td>{{ $semester->name }}</td>
                                <td>{{ $semester->start_date }}</td>
                                <td>{{ $semester->end_date }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('semesters.edit', $semester->id) }}" class="btn btn-warning btn-sm mr-2">Editar</a>
                                    <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="d-inline">
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