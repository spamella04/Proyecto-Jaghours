<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Horas</title>
</head>
<body>
    <h1>Reporte de horas trabajadas</h1>
    <p>Adjunto encontrara el PDF con los registros de horas del estudiante:</p>
    <ul>
        <li><strong>Estudiante:</strong> {{ $student->user->name }} {{ $student->user->lastname }}</li>
        <li><strong>Cif:</strong> {{ $student->user->cif }} </li>
    </ul>
    
</body>
</html>
