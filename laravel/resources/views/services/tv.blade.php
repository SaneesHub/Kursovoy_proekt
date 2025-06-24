@extends('layouts.app')

@section('title', 'Цифровое ТВ')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Пакеты телеканалов</h1>
            @if(Auth::check() && Auth::user()->id_role == 1)
                <a href="{{ route('admin.services.create') }}" class="hero-cta">
                    Добавить услугу
                </a>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $service)
            @php
                $isAdmin = Auth::check() && Auth::user()->id_role === 1;
            @endphp
                <div class="service-card service-card--tv">
                    <div class="service-card__header">
                        <h3 class="service-card__title">{{ $service->description_services }}</h3>
                        <span class="service-card__type">Телевидение</span>
                    </div>
                    
                    <div class="service-card__body">
                        <p class="service-card__description">Лучшие телеканалы в цифровом качестве с дополнительными функциями</p>
                        
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
@endsection