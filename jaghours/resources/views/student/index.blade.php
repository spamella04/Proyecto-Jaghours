@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Listado de Estudiantes</h2>
    <a href="{{ route('students.create') }}" class="btn btn-outline-primary">Crear nuevo registro de estudiante</a>
</div>


    <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>CIF</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Curso</th>
                            <th>Habilidades</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @if($user->role == 'student')
                                <tr>
                                    <td>{{ $user->cif }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->student->degree->name }}</td>
                                    <td>{{ $user->student->skills }}</td>
                                    <td>
                                        <a href="{{ route('students.show', $user->id) }}" class="btn btn-outline-primary">Ver</a>
                                        <a href="{{ route('students.edit', $user->id) }}" class="btn btn-outline-secondary">Editar</a>
                                        <form action="{{ route('students.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
    </div>
@endsection