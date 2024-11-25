<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Horas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Reporte de horas para {{ $student->user->name }} {{ $student->user->lastname }}</h1>
    <h2>{{ $semester->name }}</h2>
    <h3>Cif: {{$student->user->cif}}</h3>
    <h3>Carrera: {{$student->degree->name}}</h3>
    <h3>Email: {{$student->user->email}}</h3>
    <h3>Telefono: {{$student->user->phone}}</h3>

    <h3>Detalle de horas registradas</h3>
    

    <table>
        <thead>
            <tr>
                <th>Título del Trabajo</th>
                <th>Área</th>
                <th>Horas Trabajadas</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hourRecords as $hourRecord)
                <tr>
                    <td>{{ $hourRecord->job->job_opportunity->title ?? 'N/A' }}</td>
                    <td>{{ $hourRecord->job->job_opportunity->area_managers->areas->name ?? 'N/A' }}</td>
                    <td>{{ $hourRecord->hours_worked }}</td>
                    <td>{{ $hourRecord->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay registros de horas para este estudiante.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
