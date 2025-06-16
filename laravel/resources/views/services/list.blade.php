@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush
@section('content')
<div class="container">
    <h1 class="text-xl mb-4">Услуги типа: {{ ucfirst($type) }}</h1>
    
    @foreach($services as $service)
        <div class="bg-white rounded-xl shadow-md p-6 mb-4">
            <h2 class="text-lg font-bold">{{ $service->description_services }}</h2>
            <p class="text-gray-600">Цена: {{ $service->tariff_price }} ₽</p>
            <form method="POST" action="{{ route('services.connect', $service->id_services) }}">
                @csrf
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Подключить</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
