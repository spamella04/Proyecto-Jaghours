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
        <h2 class="font-weight-bold">Listado de Estudiantes</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-lg btn-create">Crear nuevo registro de estudiante</a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CIF</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Curso</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @if($user->role == 'student' )
                    <tr>
                        <td>{{ $user->cif }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->student->degree->name }}</td>
                        @if($user->status=='active')
                            <td>Activo</td>
                        <td>
                            <a href="{{ route('students.show', $user->id) }}" class="btn btn-info btn-sm btn-action">Ver</a>
                            <a href="{{ route('students.edit', $user->id) }}" class="btn btn-warning btn-sm btn-action">Editar</a>
                            <form action="{{ route('students.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-action">Desactivar</button>
                            </form>
                        </td>
                        @endif
                        @if($user->status=='inactive')
                            <td>Inactivo</td>
                            <td>
                            <form action="{{ route('students.notdestroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm btn-action">Activar</button>
                            </form>
                            </td>
                        @endif
                    </tr>   
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
