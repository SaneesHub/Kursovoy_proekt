@extends('layouts.app')

@section('title', 'Редактирование оборудования')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="form-container">
        <h1 class="form-title">Редактировать оборудование</h1>
        
        <form action="{{ route('admin.reports.network.update', $device->id_device) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Название:</label>
                <input type="text" name="type_device" value="{{ $device->type_device }}" required 
                       class="form-input">
            </div>
            
            <div class="form-group">
                <label class="form-label">Услуга:</label>
                <select name="id_services" class="form-select">
                    <option value="">-- Не назначено --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id_services }}"
                            {{ optional($device->implements->first())->id_services == $service->id_services ? 'selected' : '' }}>
                            {{ $service->description_services }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Сохранить
                </button>
                <a href="{{ route('admin.reports.network') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Отмена
                </a>
            </div>
        </form>
        
        <div class="delete-form">
            <form action="{{ route('admin.reports.network.destroy', $device->id_device) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить это оборудование?')">
                    <i class="fas fa-trash-alt"></i> Удалить оборудование
                </button>
            </form>
        </div>
    </div>
</div>
@endsection