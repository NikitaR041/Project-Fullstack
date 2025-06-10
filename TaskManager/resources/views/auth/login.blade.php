@extends('layouts.app')

@section('title', 'Регистрация')

{{-- Используем те же стили, что и для формы регистрации --}}
@section('content')
    <section class="view_register">
        <div class="register-container">
            <img src="/images/logo.png" alt="Логотип TaskDino" class="register-logo">
            <h1 class="register-title">Вход</h1>

            <form method="POST" action="{{ route('login') }}" class="register-form">
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

                {{-- <div class="form-group">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div> --}}

                <button type="submit" class="register-button">Вход</button>

                <div class="auth-switch">
                    Нет аккаунта? <a href="{{ route('register.form') }}" class="auth-link">Зарегистрироваться</a>
                </div>
            </form>
        </div>
    </section>
@endsection
