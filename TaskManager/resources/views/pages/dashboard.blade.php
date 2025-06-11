@extends('layouts.app')

@section('content')
<div class="dashboardheader">
    <div>
        <span>👤 Зашел: {{ Auth::user()->name }}</span>
    </div>
    {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать аккаунт</a> --}}
    <a class="btn btn-secondary">Создать проект</a>
    <a class="btn btn-secondary">Создать задачу</a>
    <a class="btn btn-secondary">Расписание</a>
    <a href="{{ route('logout') }}" class="btn btn-secondary">Выход</a>
    {{-- <img src="/image/logo.png" alt="Логотип TaskDino" class="register-logo"> --}}
</div>

<div class="dashboardmain">
    <div class="project-section scroll-container">
        <h2>Проекты</h2>
        <div class="cards">
            {{-- Условное создание карточек --}}
            <div class="card">Проект 1</div>
            <div class="card">Проект 2</div>
            <div class="card">Проект 3</div>
            <div class="card">Проект 4</div>
            <div class="card">Проект 1</div>
            <div class="card">Проект 2</div>
            <div class="card">Проект 3</div>
            <div class="card">Проект 4</div>
            <div class="card">Проект 2</div>
            <div class="card">Проект 3</div>
            <div class="card">Проект 4</div>
        </div>
    </div>

    <div class="tasks-section scroll-container">
        <h2>Задачи</h2>
        <div class="cards">
            {{-- Условное создание карточек --}}
            <div class="card">Задача 1</div>
            <div class="card">Задача 2</div>
            <div class="card">Задача 3</div>
            <div class="card">Задача 4</div>
            <div class="card">Задача 1</div>
            <div class="card">Задача 2</div>
            <div class="card">Задача 3</div>
            <div class="card">Задача 4</div>
        </div>
    </div>
</div>
@endsection
