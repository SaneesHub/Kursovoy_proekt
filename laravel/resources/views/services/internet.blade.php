@extends('layouts.app')

@section('title', 'Интернет')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush
@section('content')
    <h2>Интернет-услуги</h2>
    <div class="container">
        @foreach ($services as $service)
            <div class="card">
                <h3>{{ $service->description_services }}</h3>
                <p><strong>Цена: </strong>{{ $service->tariff_price }} ₽</p>
                <a href="{{ route('services.connect', $service->id_services) }}" 
                    class="btn btn-primary">
                    Подключить
                    </a>
            </div>
        @endforeach
    </div>
@endsection
