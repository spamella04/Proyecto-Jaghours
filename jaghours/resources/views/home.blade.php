@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenido') }}, {{ Auth::user()->name }}</div>

                <div class="card-body">
                    @if(Auth::user()->role === 'admin')
                        {{-- Contenido para admin --}}
                        <h2>Panel de Administrador</h2>
                        <p>Administra estudiantes, áreas, carreras, semestres, y más.</p>
                        <a href="{{ route('students.index') }}" class="btn btn-primary">Administrar Estudiantes</a>
                     
                    @elseif(Auth::user()->role === 'areamanager')
                        {{-- Contenido para responsable de área --}}
                        <h2>Responsable de Área</h2>
                        <p>Consulta y gestiona solicitudes de publicaciones.</p>
                        <a href="{{ route('joboportunity.index') }}" class="btn btn-primary">Ver Solicitudes</a>
                      
                    @elseif(Auth::user()->role === 'student')
                        {{-- Contenido para estudiante --}}
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm rounded-lg">
                                    <img src="{{ asset('assets/images/imagen1.png') }}" class="card-img-top" alt="Imagen 1">
                                    <div class="card-body">
                                        <h5 class="card-title">Descubre las emocionantes y variadas ofertas de trabajo</h5>
                                        <p class="card-text">Selecciona un área para ver las oportunidades de trabajo que mejor se adapten a tus intereses y habilidades.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm rounded-lg">
                                    <img src="{{ asset('assets/images/imagen2.png') }}" class="card-img-top" alt="Imagen 2">
                                    <div class="card-body">
                                        <h5 class="card-title">Nuestro listado se actualiza regularmente</h5>
                                        <p class="card-text">Estamos constantemente actualizando nuestras ofertas para ofrecerte las mejores opciones disponibles.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm rounded-lg">
                                    <img src="{{ asset('assets/images/imagen2.png') }}" class="card-img-top" alt="Imagen 3">
                                    <div class="card-body">
                                        <h5 class="card-title">Postúlate a las ofertas que más te interesen</h5>
                                        <p class="card-text">Recuerda que puedes postularte a las ofertas de trabajo que más te interesen y acumular tus horas laborales de manera eficiente.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('joboportunity.indexStudent') }}" class="btn  mt-4" style="background-color: #219EBC; border-color: #219EBC; color: #fff">Ver Publicaciones</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
