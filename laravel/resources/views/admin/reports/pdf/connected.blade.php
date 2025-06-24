<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    body { font-family: 'DejaVu Sans', sans-serif; }
</style>
<h1>Подключённые услуги</h1>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Тип услуги</th>
            <th>Описание</th>
            <th>Дата подключения</th>
            <th>Оборудование</th>
            <th>Адрес</th>
            <th>Цена</th>
            <th>Статус оплаты</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row['Тип услуги'] }}</td>
                <td>{{ $row['Описание услуги'] }}</td>
                <td>{{ $row['Дата подключения'] }}</td>
                <td>{{ $row['Оборудование'] }}</td>
                <td>{{ $row['Адрес подключения'] }}</td>
                <td>{{ $row['Стоимость'] }} ₽</td>
                <td>{{ $row['Статус оплаты'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
