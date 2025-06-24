@extends('layouts.app')

@section('title', 'Подключение услуги')

@section('content')
    <h1 class="page-title">Подключение услуги: {{ $service->type_services }}</h1>

    <div class="card single-service">
        <p><strong>Описание:</strong> {{ $service->description_services }}</p>
        <p><strong>Стоимость:</strong> {{ $service->tariff_price }} ₽/мес</p>

        @auth
            <form action="{{ route('services.subscribe', $service->id_services) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name_guest" class="form-label">ФИО</label>
                    <input type="text" class="form-control" id="name_guest" name="name_guest" required>
                </div>
                
                <div class="mb-3">
                    <label for="email_guest" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_guest" name="email_guest" required>
                </div>
                
                <div class="mb-3">
                    <label for="address_connection" class="form-label">Адрес подключения</label>
                    <input type="text" class="form-control" id="address_connection" name="address_connection" required>
                </div>
                <button class="btn">Подключить</button>
            </form>
        @else
            <p>Для подключения услуги необходимо <a href="{{ route('login') }}">войти</a> в систему.</p>
        @endauth
    </div>
@endsection
