@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h2 class="mb-0">{{ __('Editar Carrera') }}</h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('degrees.update', $degree->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="code" class="form-label font-weight-bold">{{ __('Código') }}</label>
                            <input id="code" name="code" type="text" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $degree->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label font-weight-bold">{{ __('Nombre') }}</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $degree->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-dark">{{ __('Editar Carrera') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection