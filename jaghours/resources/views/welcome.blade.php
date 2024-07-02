@extends('layouts.app')

@section('content')
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido</title>


    <!-- Estilos personalizados -->
    <style>

        .image-container {
            display:inline-block;
            background-color: #219EBC;
            padding:30px;
        }
       .header-img {
            position: relative;
            width: 100%;
            height: auto;
            overflow: hidden;
           
        }

        .header-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .text-shadow{
            text-shadow:2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .nav-image{
            width: 100px;
            height: 100px;
        }

        .section-title {
            text-align: center;
            margin: 30px 0;
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .text-highlight{
            color: #219EBC;
        }

        .footer-bg{
            background-color: #219EBC;
            color: white;
        }
    </style>

    
</head>
<body class="bg-white">
    <!-- Contenido de bienvenida -->
    <div class="image-container">
        <div class="header-img pt-2">
        <img src="{{ asset('assets/images/estudiantes.jpg') }}" alt="Imagen de bienvenida" class="img-fluid header-img">  
            <div class="header-text">
            <h1 class="text-shadow"> Bienvenido a Jaghours</h1>
            </div>
        </div>
    </div>
    <div class="container mt-4">
      
        <div class="row">
            <div class="col-12 text-center">
                <h2>Panel de Gestion de Vida Estudiantil</h2>
                <p >Encuentra las mejores oportunidades de trabajo para estudiantes y gestiona tus horas laborales de manera eficiente.</p>
            </div>
        </div>
        <h2 class="section-title text-highlight">¿Qué funciones puedes realizar?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="{{asset ('assets/images/hombre.jpg') }}" class="card-img-top" alt="Publicar Oferta de Trabajo">
                    <div class="card-body">
                        <h5 class="card-title">Publicar Oferta de Trabajo</h5>
                        <p class="card-text">Crea y publica nuevas oportunidades de trabajo para los estudiantes becados. ¡Ayuda a impulsar las carreras de nuestros estudiantes!</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img src="{{asset ('assets/images/typing.jpg') }}" class="card-img-top" alt="Ver Solicitudes de Trabajo">
                    <div class="card-body">
                        <h5 class="card-title">Ver Solicitudes de Trabajo</h5>
                        <p class="card-text">Revisa y gestiona las solicitudes enviadas por las áreas de la universidad. Aprueba, rechaza o solicita más información antes de publicar oficialmente las ofertas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{asset ('assets/images/grafica.jpg') }}" class="card-img-top" alt="Gestionar Horas Laborales">
                    <div class="card-body">
                        <h5 class="card-title">Gestionar Horas Laborales</h5>
                        <p class="card-text">Registra, actualiza y supervisa las horas laborales de los estudiantes. Mantén un seguimiento claro del progreso y la dedicación de nuestros becarios.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{asset ('assets/images/gente.jpg') }}" class="card-img-top" alt="Revisar Postulaciones de Estudiantes">
                    <div class="card-body">
                        <h5 class="card-title">Revisar Postulaciones de Estudiantes</h5>
                        <p class="card-text">Evalúa las postulaciones enviadas para las oportunidades de trabajo. Selecciona a los candidatos ideales para las posiciones disponibles.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

            

    </div>
    <!-- Footer -->
    <footer class="footer-bg">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center pt-5">
                    <p>© 2024 JagHours. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
@endsection