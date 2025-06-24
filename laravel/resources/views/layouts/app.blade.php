<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Интернет-провайдер')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="main-header">
        <div class="container mx-auto px-4">
            <nav class="main-nav">
                <div class="logo">
                    <a href="{{ route('home') }}" class="logo-link">NetProvider</a>
                </div>
                
                <div class="nav-links">
                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt mr-2"></i>Мои услуги
                        </a>
                    @endauth
                    
                    <a href="{{ route('internet') }}" class="nav-link">
                        <i class="fas fa-wifi mr-2"></i>Интернет
                    </a>
                    
                    <a href="{{ route('tv') }}" class="nav-link">
                        <i class="fas fa-tv mr-2"></i>ТВ
                    </a>
                    
                    <a href="{{ route('mobile') }}" class="nav-link">
                        <i class="fas fa-mobile-alt mr-2"></i>Мобильная связь
                    </a>
                </div>
                
                <div class="auth-links">
                    @guest
                        <a href="{{ route('login') }}" class="auth-link login-link">
                            <i class="fas fa-sign-in-alt mr-2"></i>Вход
                        </a>
                        <a href="{{ route('register') }}" class="auth-link register-link">
                            <i class="fas fa-user-plus mr-2"></i>Регистрация
                        </a>
                    @endguest
                    
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="auth-link logout-link">
                                <i class="fas fa-sign-out-alt mr-2"></i>Выход
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container mx-auto px-4">
            <div class="footer-content">
                <div class="footer-info">
                    <p class="copyright">&copy; {{ date('Y') }} NetProvider. Все права защищены.</p>
                    <div class="footer-contacts">
                        <a href="tel:+78001234567" class="contact-link">
                            <i class="fas fa-phone-alt mr-2"></i>8 (800) 123-45-67
                        </a>
                        <a href="mailto:support@netprovider.ru" class="contact-link">
                            <i class="fas fa-envelope mr-2"></i>support@netprovider.ru
                        </a>
                    </div>
                </div>
                
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-vk"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>