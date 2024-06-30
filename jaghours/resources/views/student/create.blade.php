@extends('layouts.app')
@section('content')

<div class="container">
    <h2>Ingrese la información del Estudiante:</h2>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="col-2 col-md-4 mb-3">
            <label for="cif" class="form-label">CIF</label>
            <input type="text" class="form-control" id="cif" name="cif">
        </div>

        <div class="mb-3">
            <select class="form-control" id="degree_id" name="degree_id">
                <option value="">Seleccione su carrera principal</option>
                @foreach($degrees as $degree)
                    <option value="{{ $degree->id }}">{{ $degree->code }}-{{ $degree->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="lastname" name="lastname">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Telefono</label>
            <input type="phone" class="form-control" id="phone" name="phone">
        </div>

        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <input type="skills" class="form-control" id="skills" name="skills">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

@endsection