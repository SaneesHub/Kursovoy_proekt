@extends('layouts.app')
@section('title', 'Главная — Услуги')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush
@section('content')
    <h1>Добро пожаловать в систему интернет-провайдера</h1>
    <p>Выберите интересующую услугу.</p>

    <div class="service-grid">
        @foreach ($services as $service)
            <div class="card">
                <h3>{{ $service->Name }}</h3>
                <p>{{ $service->Description }}</p>
                <p><strong>Цена:</strong> {{ $service->Price }} ₽</p>

                @if (Auth::check())
                    @php $roleId = Auth::user()->id_role; @endphp

                    @if ($roleId == 1)
                        <form method="POST" action="{{ route('services.connect', $service->id) }}">
                            @csrf
                            <button type="submit">Подключить</button>
                        </form>
                    @elseif ($roleId == 2 || $roleId == 3)
                        <a href="{{ route('services.edit', $service->id) }}" class="btn edit">Редактировать</a>
                        <form method="POST" action="{{ route('services.destroy', $service->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete">Удалить</button>
                        </form>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
@endsection
