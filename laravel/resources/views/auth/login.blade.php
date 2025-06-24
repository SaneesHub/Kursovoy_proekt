@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Вход в личный кабинет</h2>
            <div class="auth-logo">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Ваш email" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Ваш пароль" required>
                </div>
            </div>

            <div class="form-options">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">Забыли пароль?</a>
                @endif
            </div>

            <button type="submit" class="auth-button">
                <i class="fas fa-sign-in-alt"></i> Войти
            </button>

            <div class="auth-footer">
                Ещё нет аккаунта? <a href="{{ route('register') }}" class="auth-link">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</div>
@endsection