@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="report-container">
        <div class="flex justify-between items-center mb-6">
            <h1 class="report-title">Подключённые услуги пользователя: {{ $user->fio }}</h1>
            <a href="{{ url()->previous() }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Назад
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Услуга</th>
                        <th>Цена</th>
                        <th>Дата подключения</th>
                        <th>Дата отключения</th>
                        <th>Статус оплаты</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($connections as $conn)
                        <tr>
                            <td>{{ $conn->description_services }}</td>
                            <td class="price-value">{{ number_format($conn->tariff_price, 2) }} ₽</td>
                            <td>{{ $conn->date_connection->format('d.m.Y') }}</td>
                            <td>{{ $conn->date_disconnection ? $conn->date_disconnection->format('d.m.Y') : '—' }}</td>
                            <td>
                                @if($conn->status_payment)
                                    <span class="status-paid">Оплачено</span>
                                @else
                                    <span class="status-unpaid">Не оплачено</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reports.service.edit', $conn->id_connection) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.reports.service.destroy', $conn->id_connection) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Удалить подключение?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection