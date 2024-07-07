@extends ('layouts.app')

@section ('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h2 class="mb-0">{{ __('Crear Semestre') }}</h2>

                </div>
                <div class="card-body p-4">
                    <form action="{{route('semesters.store')}}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label font-weight-bold">{{ __('Nombre') }}</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label font-weight-bold">{{ __('Fecha de Inicio') }}</label>
                            <input id="start_date" name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label font-weight-bold">{{ __('Fecha de Finalizacion') }}</label>
                            <input id="end_date" name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hours_required" class="form-label font-weight-bold">{{ __('Horas Requeridas') }}</label>
                            <input id="hours_required" name="hours_required" type="number" class="form-control @error('hours_required') is-invalid @enderror" value="{{ old('hours_required') }}" required>
                            @error('hours_required')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        <div class="text-center">
                            <button type="submit" class="btn btn-dark">{{ __('Crear Semestre') }}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection