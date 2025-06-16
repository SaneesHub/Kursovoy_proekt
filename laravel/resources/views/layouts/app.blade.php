<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Интернет-провайдер')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <div class="navbar">
            @auth
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Мои услуги</a>
            @endauth
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('internet') }}">Интернет</a>
            <a href="{{ route('tv') }}">ТВ</a>
            <a href="{{ route('mobile') }}">Мобильная связь</a>
            
            @guest
                <a href="{{ route('login') }}">Вход</a>
                <a href="{{ route('register') }}">Регистрация</a>
            @endguest
            
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Выход</button>
                </form>
            @endauth
        </div>
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Интернет-провайдер. Все права защищены.</p>
    </footer>
</body>
</html>