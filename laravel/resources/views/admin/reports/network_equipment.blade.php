<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оборудование</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-size: 14px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Оборудование и реализуемые услуги</h2>
    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>MAC-адрес</th>
                <th>IP-адрес</th>
                <th>Адрес подключения</th>
                <th>Тип услуги</th>
                <th>Описание услуги</th>
                <th>Описание ошибки</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipment as $item)
                <tr>
                    <td>{{ $item->Название }}</td>
                    <td>{{ $item->{"MAC-адрес"} }}</td>
                    <td>{{ $item->{"IP-адрес"} }}</td>
                    <td>{{ $item->{"Адрес подключения"} }}</td>
                    <td>{{ $item->{"Тип реализуемой услуги"} }}</td>
                    <td>{{ $item->{"Описание услуги"} }}</td>
                    <td>{{ $item->{"Описание ошибки"} }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
