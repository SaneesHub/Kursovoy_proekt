@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-xl mb-4">Управление услугами</h1>
        <a href="{{ route('admin.services.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Добавить услугу</a>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Описание</th>
                    <th class="border px-4 py-2">Тип</th>
                    <th class="border px-4 py-2">Цена</th>
                    <th class="border px-4 py-2">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td class="border px-4 py-2">{{ $service->ID_services }}</td>
                        <td class="border px-4 py-2">{{ $service->Description_services }}</td>
                        <td class="border px-4 py-2">{{ $service->type_services }}</td>
                        <td class="border px-4 py-2">{{ $service->Tariff_price }} ₽</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.services.edit', $service->ID_services) }}" class="text-blue-500">Редактировать</a>
                            <form action="{{ route('admin.services.destroy', $service->ID_services) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
