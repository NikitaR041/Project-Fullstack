@extends('layouts.app')

@section('title', 'Добро пожаловать')

@section('content')
    <section class="cover">
        <div class="left-section">
            <img src="images/logo.png" alt="Логотип сайта" class="logo">
            <h1>TaskDino</h1>
            <h2>
                Твой задачник дел!<br>
                Не забудь про важные мероприятия!
            </h2>
        </div>

        <div class="right-section">
            <div class="auth-buttons">
                <a href="{{ route('register.form') }}" class="btn btn-primary">Регистрация</a>
                <a href="{{ route('login.form') }}" class="btn btn-secondary">Вход</a>
            </div>
        </div>
    </section>
@endsection
