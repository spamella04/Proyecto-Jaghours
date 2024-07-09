@extends('layouts.app')

@section('content')

<style>
    .profile-container {
        max-width: 100%;
        margin: auto;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-main {
        flex: 1;
        padding-right: 30px;
        min-width: 0; /* Ensure it can shrink */
        word-wrap: break-word; /* Allow long words to wrap */
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .profile-header .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #219EBC;
        color: #fff;
        font-size: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 20px;
    }

    .profile-header .avatar span {
        text-transform: uppercase;
    }

    .profile-info {
        margin-bottom: 20px;
    }

    .profile-info h2 {
        font-weight: bold;
        margin-bottom: 10px;
        word-break: break-word; /* Break long names */
    }

    .profile-info .details {
        margin-bottom: 10px;
    }

    .profile-actions {
        text-align: right;
        margin-top: 20px;
    }

    .profile-actions a.btn {
        background-color: #219EBC;
        border-color: #219EBC;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: opacity 0.3s ease;
    }

    .profile-actions a.btn:hover {
        opacity: 0.8;
    }

    .profile-secondary {
        flex: 1;
        padding-left: 30px;
        min-width: 0; /* Ensure it can shrink */
    }

    .profile-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .profile-card h3 {
        font-weight: bold;
        margin-bottom: 15px;
    }

    .profile-card p {
        margin-bottom: 5px;
    }
</style>

<div class="container-fluid py-5">
    <div class="profile-container">
        <div class="profile-main">
            <div class="card shadow-sm rounded-lg">
                <div class="card-body">
                    <h2 class="card-title mb-4 font-weight-bold text-center">Perfil del Estudiante</h2>
                    <div class="profile-header">
                        <div class="avatar"><span>{{ strtoupper(substr($user->name, 0, 1)) }}</span></div>
                        <div class="profile-info">
                            <h2>{{ $user->name }} {{ $user->lastname }}</h2>
                            <div class="details">
                                <p><strong>Correo:</strong> {{ $user->email }}</p>
                                <p><strong>Teléfono:</strong> {{ $user->phone }}</p>
                            </div>
                            <div class="details">
                                <p><strong>CIF:</strong> {{ $user->cif }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('students.index') }}" class="btn btn-primary float-end" style="background-color: #219EBC; border-color: #219EBC;">Regresar</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="profile-secondary">
            <div class="profile-card">
                <h3>Carrera</h3>
                <p>{{ $user->student->degree->name }}</p>
            </div>
            <div class="profile-card">
                <h3>Habilidades</h3>
                <p>{{ $user->student->skills }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
