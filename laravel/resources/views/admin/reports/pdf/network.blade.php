<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 12;}
</style>
<h1>Сетевое оборудование и ошибки</h1>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
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
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row['Название'] }}</td>
                <td>{{ $row['MAC-адрес'] }}</td>
                <td>{{ $row['IP-адрес'] }}</td>
                <td>{{ $row['Адрес подключения'] }}</td>
                <td>{{ $row['Тип реализуемой услуги'] }}</td>
                <td>{{ $row['Описание услуги'] }}</td>
                <td>{{ $row['Описание ошибки'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
