@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Создание аккаунта</h2>
            <div class="auth-logo">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            
            @if($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name" class="form-label">ФИО</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Ваше полное имя" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Ваш email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Придумайте пароль" required>
                </div>
                <div class="password-hint">Минимум 8 символов</div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Подтверждение пароля</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-input" placeholder="Повторите пароль" required>
                </div>
            </div>

            <button type="submit" class="auth-button">
                <i class="fas fa-user-plus"></i> Зарегистрироваться
            </button>

            <div class="auth-footer">
                Уже есть аккаунт? <a href="{{ route('login') }}" class="auth-link">Войти</a>
            </div>
        </form>
    </div>
</div>
@endsection