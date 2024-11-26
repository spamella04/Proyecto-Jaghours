@extends('layouts.app')

@section('content')
<head>
    
    <style>
        .card-custom {
    height: 100%; 
    transition: transform 0.3s, box-shadow 0.3s; 
}

.card-custom img {
    object-fit: cover; 
    height: 200px; 
}

.card-custom:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); 
}


.carousel-caption-container {
    text-align: center;
    margin-top: 15px; 
}

.carousel-caption-container h5 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
}

.carousel-caption-container p {
    font-size: 1rem;
    color: #777;
}

    </style>
</head>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Hola') }}, {{ Auth::user()->name . ' ' . Auth::user()->lastname }}</div>

                <div class="card-body">
                @if(Auth::user()->role === 'admin')
    {{-- Contenido para admin --}}
    <h2>Panel de Administrador</h2>
    <!-- Carrusel de imágenes -->
    <div id="adminCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Primer item del carrusel -->
            <div class="carousel-item active">
                <img src="{{ asset('assets/images/imagen2.png') }}" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-caption-container">
                <h5>Bienvenido al Panel de Administrador</h5>
                <p>Administra todos los recursos de la plataforma.</p>
            </div>

            <!-- Segundo item del carrusel -->
            <div class="carousel-item">
                <img src="{{ asset('assets/images/imagen1.png') }}" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-caption-container">
                <h5>Gestión de Estudiantes</h5>
                <p>Visualiza y administra la información de los estudiantes.</p>
            </div>

            <!-- Tercer item del carrusel -->
            <div class="carousel-item">
                <img src="{{ asset('assets/images/imagen3.png') }}" class="d-block w-100" alt="Imagen 3">
            </div>
            <div class="carousel-caption-container">
                <h5>Gestión de Oportunidades de Trabajo</h5>
                <p>Publica las solicitudes de oportunidades de trabajo de cada área.</p>
            </div>

            <!-- Cuarto item del carrusel -->
            <div class="carousel-item">
                <img src="{{ asset('assets/images/imagen4.png') }}" class="d-block w-100" alt="Imagen 4">
            </div>
            <div class="carousel-caption-container">
                <h5>Gestión de Horas Laborales</h5>
                <p>Registra y consulta el progreso de horas trabajadas por los estudiantes.</p>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#adminCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#adminCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
                   
    @elseif(Auth::user()->role === 'areamanager')
                {{-- Contenido para responsable de área --}}
                <h2>Responsable de Área</h2>
                <p>Consulta y gestiona solicitudes de publicaciones.</p>
                <a href="{{ route('joboportunity.index') }}" class="btn btn-primary" style="background-color: #219EBC; border-color: #219EBC; color: #fff">Ver Solicitudes</a>
                      
     @elseif(Auth::user()->role === 'student')
                        {{-- Contenido para estudiante --}}
                        <div class="row">
    <div class="col-md-4 mb-4">
        <div class="card card-custom shadow-sm rounded-lg">
            <img src="{{ asset('assets/images/imagen1.png') }}" class="card-img-top img-fluid" alt="Imagen 1">
            <div class="card-body">
                <h5 class="card-title">Descubre las emocionantes y variadas ofertas de trabajo</h5>
                <p class="card-text">Selecciona un área para ver las oportunidades de trabajo que mejor se adapten a tus intereses y habilidades.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card card-custom shadow-sm rounded-lg">
            <img src="{{ asset('assets/images/imagen2.png') }}" class="card-img-top img-fluid" alt="Imagen 2">
            <div class="card-body">
                <h5 class="card-title">Nuestro listado se actualiza regularmente</h5>
                <p class="card-text">Estamos constantemente actualizando nuestras ofertas para ofrecerte las mejores opciones disponibles.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card card-custom shadow-sm rounded-lg">
            <img src="{{ asset('assets/images/imagen3.png') }}" class="card-img-top img-fluid" alt="Imagen 3">
            <div class="card-body">
                <h5 class="card-title">Postúlate a las ofertas que más te interesen</h5>
                <p class="card-text">Recuerda que puedes postularte a las ofertas de trabajo que más te interesen y acumular tus horas laborales de manera eficiente.</p>
            </div>
        </div>
    </div>
</div>

                        
                        <a href="{{ route('joboportunity.indexStudent') }}" class="btn  mt-4" style="background-color: #219EBC; border-color: #219EBC; color: #fff">Ver publicaciones</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
