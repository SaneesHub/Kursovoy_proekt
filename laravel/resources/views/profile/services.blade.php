@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Мои подключённые услуги</h1>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if($services->isEmpty())
        <p class="text-gray-600">Вы пока не подключили ни одной услуги.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($services as $activation)
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold">{{ $activation->service->Description_services }}</h3>
                    <p class="text-gray-600">Цена: {{ $activation->service->Tariff_price }} ₽/мес</p>
                    <p class="text-sm text-gray-500">Тип: {{ ucfirst($activation->service->type_services) }}</p>
                    <form method="POST" action="{{ route('service.disconnect', $activation->ID_connection) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Отключить
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
