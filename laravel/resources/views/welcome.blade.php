@extends('layouts.app')

@section('content')
@vite(['resources/css/app.css'])

<div class="services-page">
    <div class="services-container">
        <h1 class="section-title">Наши услуги</h1>

        {{-- Интернет --}}
        <h2 class="section-title">Интернет</h2>
        <div class="services-grid">
            @foreach ($internetServices as $service)
                <div class="service-card">
                    <div class="service-header">
                        <h3>{{ $service->description_services }}</h3>
                    </div>
                    <div class="service-body">
                        <p class="service-price">{{ $service->tariff_price }} ₽/мес</p>
                        <a href="{{ route('services.connect', $service->id_services) }}" 
                            class="btn btn-primary">
                            Подключить
                            </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ТВ --}}
        <h2 class="section-title">Телевидение</h2>
        <div class="services-grid">
            @foreach ($tvServices as $service)
                <div class="service-card">
                    <div class="service-header">
                        <h3>{{ $service->description_services }}</h3>
                    </div>
                    <div class="service-body">
                        <p class="service-price">{{ $service->tariff_price }} ₽/мес</p>
                        <a href="{{ route('services.connect', $service->id_services) }}" 
                            class="btn btn-primary">
                            Подключить
                            </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Мобильная связь --}}
        <h2 class="section-title">Мобильная связь</h2>
        <div class="services-grid">
            @foreach ($mobileServices as $service)
                <div class="service-card">
                    <div class="service-header">
                        <h3>{{ $service->description_services }}</h3>
                    </div>
                    <div class="service-body">
                        <p class="service-price">{{ $service->tariff_price }} ₽/мес</p>
                        <a href="{{ route('services.connect', $service->id_services) }}" 
                            class="btn btn-primary">
                            Подключить
                            </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection