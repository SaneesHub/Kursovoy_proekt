@extends('layouts.app')

@section('content')
<div class="home-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container mx-auto px-4 py-20 text-center">
            <h1 class="hero-title">Современные телекоммуникационные решения</h1>
            <p class="hero-subtitle">Высокоскоростной интернет, цифровое телевидение и мобильная связь</p>
            <a href="#services" class="hero-cta">Посмотреть тарифы</a>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="section-title">Наши услуги</h2>
            
            <!-- Internet Services -->
            <div class="service-category">
                <div class="category-header">
                    <i class="fas fa-wifi category-icon"></i>
                    <div class="flex items-center justify-between">
                        <h3 class="category-title">Интернет</h3>
                        @if(Auth::check() && Auth::user()->id_role == 1)
                            <a href="{{ route('admin.services.create') }}" class="hero-cta">
                                Добавить услугу
                            </a>
                        @endif
                    </div>
                </div>
                <div class="services-grid">
                    @foreach ($internetServices as $service)
                    @php
                        $isAdmin = Auth::check() && Auth::user()->id_role === 1;
                    @endphp
                        <div class="service-card service-card--internet">
                            <div class="service-card__header">
                                <h4 class="service-card__title">{{ $service->description_services }}</h4>
                            </div>
                            <div class="service-card__body">
                                <div class="service-card__price">
                                    {{ $service->tariff_price }} <span class="service-card__price-period">₽/месяц</span>
                                </div>
                            </div>
                            <div class="service-card__footer">
                                <a href="{{ route('services.connect', $service->id_services) }}" class="btn-connect">
                                    Подключить <i class="fas fa-arrow-right"></i>
                                </a>
                                @if($isAdmin)
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('admin.services.edit', $service->id_services) }}"
                                        class="btn bg-yellow-500 text-white text-sm px-3 py-1 rounded hover:bg-yellow-600">
                                            <i class="fas fa-edit mr-1"></i>Редактировать
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id_services) }}" method="POST"
                                            onsubmit="return confirm('Вы уверены, что хотите удалить услугу?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700">
                                                <i class="fas fa-trash-alt mr-1"></i>Удалить
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TV Services -->
            <div class="service-category mt-16">
                <div class="category-header">
                    <i class="fas fa-tv category-icon"></i>
                    <div class="flex items-center justify-between">
                        <h3 class="category-title">Телевидение</h3>
                        @if(Auth::check() && Auth::user()->id_role == 1)
                            <a href="{{ route('admin.services.create') }}" class="hero-cta">
                                Добавить услугу
                            </a>
                        @endif
                    </div>
                </div>
                <div class="services-grid">
                    @foreach ($tvServices as $service)
                    @php
                        $isAdmin = Auth::check() && Auth::user()->id_role === 1;
                    @endphp
                        <div class="service-card service-card--tv">
                            <div class="service-card__header">
                                <h4 class="service-card__title">{{ $service->description_services }}</h4>
                            </div>
                            <div class="service-card__body">
                                <div class="service-card__price">
                                    {{ $service->tariff_price }} <span class="service-card__price-period">₽/месяц</span>
                                </div>
                            </div>
                            <div class="service-card__footer">
                                <a href="{{ route('services.connect', $service->id_services) }}" class="btn-connect">
                                    Подключить <i class="fas fa-arrow-right"></i>
                                </a>
                                @if($isAdmin)
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('admin.services.edit', $service->id_services) }}"
                                        class="btn bg-yellow-500 text-white text-sm px-3 py-1 rounded hover:bg-yellow-600">
                                            <i class="fas fa-edit mr-1"></i>Редактировать
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id_services) }}" method="POST"
                                            onsubmit="return confirm('Вы уверены, что хотите удалить услугу?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700">
                                                <i class="fas fa-trash-alt mr-1"></i>Удалить
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Services -->
            <div class="service-category mt-16">
                <div class="category-header">
                    <i class="fas fa-mobile-alt category-icon"></i>
                    <div class="flex items-center justify-between">
                        <h3 class="category-title">Мобильная связь</h3>
                        @if(Auth::check() && Auth::user()->id_role == 1)
                            <a href="{{ route('admin.services.create') }}" class="hero-cta">
                                Добавить услугу
                            </a>
                        @endif
                    </div>
                </div>
                <div class="services-grid">
                    @foreach ($mobileServices as $service)
                    @php
                        $isAdmin = Auth::check() && Auth::user()->id_role === 1;
                    @endphp
                        <div class="service-card service-card--mobile">
                            <div class="service-card__header">
                                <h4 class="service-card__title">{{ $service->description_services }}</h4>
                            </div>
                            <div class="service-card__body">
                                <div class="service-card__price">
                                    {{ $service->tariff_price }} <span class="service-card__price-period">₽/месяц</span>
                                </div>
                            </div>
                            <div class="service-card__footer">
                                <a href="{{ route('services.connect', $service->id_services) }}" class="btn-connect">
                                    Подключить <i class="fas fa-arrow-right"></i>
                                </a>
                                @if($isAdmin)
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('admin.services.edit', $service->id_services) }}"
                                        class="btn bg-yellow-500 text-white text-sm px-3 py-1 rounded hover:bg-yellow-600">
                                            <i class="fas fa-edit mr-1"></i>Редактировать
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id_services) }}" method="POST"
                                            onsubmit="return confirm('Вы уверены, что хотите удалить услугу?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700">
                                                <i class="fas fa-trash-alt mr-1"></i>Удалить
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="section-title text-center">Почему выбирают нас</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-medal feature-icon"></i>
                    <h3 class="feature-title">Надежность</h3>
                    <p class="feature-text">99.9% uptime гарантирует стабильное соединение</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-headset feature-icon"></i>
                    <h3 class="feature-title">Поддержка 24/7</h3>
                    <p class="feature-text">Круглосуточная техническая поддержка</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-money-bill-wave feature-icon"></i>
                    <h3 class="feature-title">Прозрачные цены</h3>
                    <p class="feature-text">Никаких скрытых платежей и комиссий</p>
                </div>
            </div>
        </div>
    </section>
</div>
@include
@endsection