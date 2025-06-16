@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-xl mb-4">Редактировать услугу</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.services.update', $service->ID_services) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold">Описание:</label>
                <input type="text" name="Description_services" value="{{ $service->Description_services }}" class="w-full border px-4 py-2 rounded" required>
            </div>

            <div>
                <label class="block font-bold">Тип:</label>
                <input type="text" name="type_services" value="{{ $service->type_services }}" class="w-full border px-4 py-2 rounded" required>
            </div>

            <div>
                <label class="block font-bold">Цена (₽):</label>
                <input type="number" step="0.01" name="Tariff_price" value="{{ $service->Tariff_price }}" class="w-full border px-4 py-2 rounded" required>
            </div>

            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Сохранить</button>
            <a href="{{ route('admin.services.index') }}" class="ml-4 text-gray-600">Назад</a>
        </form>
    </div>
@endsection
