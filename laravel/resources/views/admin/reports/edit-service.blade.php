@extends('layouts.app')

@section('title', 'Редактирование услуги')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="form-container">
        <h1 class="form-title">Редактировать подключение</h1>
        
        <form action="{{ route('admin.reports.service.update', $activation->id_connection) }}" method="POST">
            @csrf @method('PUT')

            {{-- Выбор услуги --}}
            <div class="form-group">
                <label class="form-label">Услуга:</label>
                <select name="id_services" class="form-select">
                    @foreach($services as $service)
                        <option value="{{ $service->id_services }}" 
                            {{ $activation->id_services == $service->id_services ? 'selected' : '' }}>
                            {{ $service->type_services }} — {{ $service->description_services }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Адрес подключения --}}
            <div class="form-group">
                <label class="form-label">Адрес подключения:</label>
                <input type="text" name="address_connection" class="form-input" 
                       value="{{ $activation->address_connection }}" required>
            </div>

            {{-- Оборудование (если есть список устройств) --}}
            <div class="form-group">
                <label class="form-label">Оборудование:</label>
                <select name="id_device" class="form-select">
                    <option value="">-- Не выбрано --</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id_device }}"
                            {{ $activation->device_id == $device->id_device ? 'selected' : '' }}>
                            {{ $device->type_device }} ({{ $device->mac_address }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Дата отключения (если редактируемая) --}}
            <div class="form-group">
                <label class="form-label">Дата отключения:</label>
                <input type="date" name="date_disconnection" class="form-input"
                       value="{{ optional($activation->date_disconnection)->format('Y-m-d') }}">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить
                </button>
                <a href="{{ route('admin.reports.services') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Отмена
                </a>
            </div>
        </form>

        <div class="delete-form">
            <form action="{{ route('admin.reports.service.destroy', $activation->id_connection) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить это подключение?')">
                    <i class="fas fa-trash-alt"></i> Удалить подключение
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
