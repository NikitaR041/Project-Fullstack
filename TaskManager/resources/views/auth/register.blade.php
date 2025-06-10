@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <section class="view_register">
        <div class="register-container">
            <img src="/image/logo.png" alt="Логотип TaskDino" class="register-logo">
            <h1 class="register-title">Регистрация</h1>

            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>

                <button type="submit" class="register-button">Зарегистрироваться</button>

                <div class="auth-switch">
                    Уже есть аккаунт? <a href="{{ route('login.form') }}" class="auth-link">Войти</a>
                </div>
            </form>
        </div>
    </section>
@endsection
