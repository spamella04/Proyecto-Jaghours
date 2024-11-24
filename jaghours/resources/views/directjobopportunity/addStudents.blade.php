@extends('layouts.app')

@section('content')
<head>
    <style>

    .table th, .table td {
        text-align: center; 
        vertical-align: middle; 
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .table-hover tbody tr:hover {
        background-color: #e9ecef; 
    }
    .table-bordered {
        border: 1px solid #dee2e6; 
    }
  
    .input-group {
        max-width: 1400px;
        margin: 0 auto;
    }
   
    .btn {
        color: white;
        background-color: #17A2B8;
        border-color: #17A2B8;
    }
    .btn:hover {
        background-color: #138496;
        border-color: #117A8B;
    }
    /* Ajuste para la paginación */
    .page-link {
        color: #17A2B8;
    }
    .page-link:hover {
        color: #138496;
    }
    .page-item.active .page-link {
        background-color: #17A2B8;
        border-color: #17A2B8;
    }
    </style>
</head>
<div class="container">
    <h1 class="mb-4">Seleccionar Estudiante</h1>

   
    <form method="GET" action="{{ route('directjobopportunity.addStudents') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o CIF" value="{{ $search }}">
            <button type="submit" class="btn" style="background-color: #17A2B8; border-color: #17A2B8;">Buscar</button> 
        </div>
    </form>

    <!-- Tabla de estudiantes -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>CIF</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Semestre</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->user->cif }}</td>
                        <td>{{ $student->user->name }}</td>
                        <td>{{ $student->user->email }}</td>
                        <td>
                            <form action="{{ route('directjobopportunity.assignStudent') }}" method="POST">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="job_opportunity_id" value="{{ $jobOpportunityId}}">

                                <select name="semester_id" class="form-select" required>
                                    @foreach(App\Models\Semester::all() as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->name }} - {{ $semester->year }}</option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-warning btn-sm mt-2">Convalidar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron estudiantes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-3">
        {{ $students->appends(['search' => $search])->links() }}
    </div>
</div>

@endsection


