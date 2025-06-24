<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подключенные услуги</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 14px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Активные подключения</h2>
    <table>
        <thead>
            <tr>
                <th>Тип услуги</th>
                <th>Описание</th>
                <th>Дата подключения</th>
                <th>Дата отключения</th>
                <th>Адрес</th>
                <th>Оборудование</th>
                <th>Стоимость</th>
                <th>Статус оплаты</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{ $service->{"Тип услуги"} }}</td>
                    <td>{{ $service->{"Описание услуги"} }}</td>
                    <td>{{ $service->{"Дата подключения"} }}</td>
                    <td>{{ $service->{"Дата отключения"} }}</td>
                    <td>{{ $service->{"Адрес подключения"} }}</td>
                    <td>{{ $service->Оборудование }}</td>
                    <td>{{ $service->Стоимость }} ₽</td>
                    <td>{{ $service->{"Статус оплаты"} }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
