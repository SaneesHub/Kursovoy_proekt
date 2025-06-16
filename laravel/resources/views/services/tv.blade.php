@extends('layouts.app')

@section('title', 'ТВ — Услуги')

@section('content')
    <h1 class="page-title">Тарифы на цифровое ТВ</h1>

    <div class="card-grid">
        @foreach ($services as $service)
            <div class="card">
                <h3>{{ $service->description_services }}</h3>
                <p><strong>Цена: </strong>{{ $service->tariff_price }} ₽/мес</p>
                <a href="{{ route('services.connect', $service->id_services) }}" class="btn">Подключить</a>
            </div>
        @endforeach
    </div>
@endsection
