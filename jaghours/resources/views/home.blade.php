@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full px-6 py-8 bg-white shadow-md rounded-lg">
        <div class="text-2xl font-bold text-center text-gray-800 mb-8">{{ __('Dashboard') }}</div>

        <div class="text-center text-gray-600 mb-4">
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <p>{{ __('You are logged in!') }}</p>
        </div>
    </div>
</div>
@endsection
