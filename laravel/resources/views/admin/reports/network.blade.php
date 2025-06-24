@extends('layouts.app')

@section('title', 'Отчёт: Оборудование и ошибки')

@section('content')
    <div class="report-container">
        <h1 class="report-title">Отчёт: Оборудование и ошибки</h1>
        <a href="{{ route('dashboard') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Назад
        </a>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>MAC-адрес</th>
                    <th>IP-адрес</th>
                    <th>Адрес подключения</th>
                    <th>Тип услуги</th>
                    <th>Описание услуги</th>
                    <th>Описание ошибки</th>
                    <th>Изменить</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $row['Название'] }}</td>
                        <td><code>{{ $row['MAC-адрес'] }}</code></td>
                        <td><code>{{ $row['IP-адрес'] }}</code></td>
                        <td>{{ $row['Адрес подключения'] }}</td>
                        <td>{{ $row['Тип реализуемой услуги'] }}</td>
                        <td>{{ $row['Описание услуги'] }}</td>
                        <td @if($row['Описание ошибки']) style="color:rgb(35, 134, 5); font-weight: 500;" @endif>
                            {{ $row['Описание ошибки'] ?: 'Нет ошибок' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.reports.network.edit', $row['id_device']) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <form action="{{ route('admin.reports.network.destroy', $row['id_device']) }}" method="POST" style="display:inline;">
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