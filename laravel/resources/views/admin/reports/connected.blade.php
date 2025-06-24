@extends('layouts.app')

@section('title', 'Отчёт: Подключённые услуги')

@section('content')
    <div class="report-container">
        <h1 class="report-title">Отчёт: Подключённые услуги</h1>
        <a href="{{ route('dashboard') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Назад
        </a>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Тип услуги</th>
                    <th>Описание</th>
                    <th>Дата подключения</th>
                    <th>Оборудование</th>
                    <th>Адрес</th>
                    <th>Цена</th>
                    <th>Статус оплаты</th>
                    <th>Изменить</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $row['Тип услуги'] }}</td>
                        <td>{{ $row['Описание услуги'] }}</td>
                        <td>{{ date('d.m.Y', strtotime($row['Дата подключения'])) }}</td>
                        <td>{{ $row['Оборудование'] }}</td>
                        <td>{{ $row['Адрес подключения'] }}</td>
                        <td class="price-value">{{ number_format($row['Стоимость'], 2) }} ₽</td>
                        <td>
                            <span class="{{ $row['Статус оплаты'] === 'Оплачено' ? 'status-paid' : 'status-unpaid' }}">
                                {{ $row['Статус оплаты'] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.reports.service.edit', $row['id_connection']) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <form action="{{ route('admin.reports.service.destroy', $row['id_connection']) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn-delete">
                                    <i class="fas fa-trash-alt"></i> Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection