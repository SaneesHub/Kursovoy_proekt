@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Ваши подключённые услуги</h1>

        @if ($services->isEmpty())
            <p class="text-gray-600">У вас пока нет подключённых услуг.</p>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($services as $activation)
                    <div class="bg-white rounded-xl shadow p-4">
                        <h2 class="text-lg font-semibold">{{ $activation->service->type_services }}</h2>
                        <p class="text-gray-600">Скорость: {{ $activation->service->description_services }}</p>
                        <p class="text-gray-800 font-bold">Цена: {{ $activation->service->tariff_price }} ₽</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
