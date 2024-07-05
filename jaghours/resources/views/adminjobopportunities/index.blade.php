@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h3 class="mb-0">Listado de Solicitudes</h3>
                </div>

                <div class="card-body p-5">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Área</th>
                                <th scope="col">Horas Convalidadas</th>
                                <th scope="col">Fecha de Inicio</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobOpportunities as $joboportunity)
                                <tr>
                                    <td>{{ $joboportunity->title }}</td>
                                    <td>{{ $joboportunity->area_managers->areas->name }}</td>
                                    <td>{{ $joboportunity->hours_validated }}</td>
                                    <td>{{ $joboportunity->start_date }}</td>

                                    <td>
                                        <a href="{{ route('adminjobopportunities.show', $joboportunity) }}" class="btn btn-primary btn-sm">Ver</a>
                                        <form action="{{ route('joboportunity.destroy', $joboportunity) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

@endsection