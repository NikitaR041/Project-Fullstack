@extends('layouts.app')

@section('content')
<div class="dashboardheader">
    <div>
        <span>👤 Зашел: {{ Auth::user()->name }}</span>
    </div>
    {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать аккаунт</a> --}}
    <a href="{{ route('projects.create') }}" class="btn btn-secondary">Создать проект</a>
    <a href="{{ route('tasks.create') }}" class="btn btn-secondary">Создать задачу</a>
    <a class="btn btn-secondary">Расписание</a>
    <a href="{{ route('logout') }}" class="btn btn-secondary">Выход</a>
    {{-- <img src="/image/logo.png" alt="Логотип TaskDino" class="register-logo"> --}}
</div>

<div class="dashboardmain">
    <div class="project-section scroll-container">
        <h2>Проекты</h2>
        <div class="cards">
            @forelse($projects as $project)
                <a href="{{ route('projects.show', $project->id) }}" class="card">
                    <strong>{{ $project->title }}</strong><br>
                    <small>{{ $project->description }}</small><br>
                    {{-- <small>Категория: {{ $project->category->name ?? 'Без категории' }}</small><br> --}}
                    {{-- <small>Дедлайн: {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d.m.Y') : 'Не указан' }}</small><br> --}}
                </a>
            @empty
                <div>У вас пока нет проектов</div>
            @endforelse
        </div>
    </div>

    <div class="tasks-section scroll-container">
        <h2>Задачи</h2>
        <div class="cards">
            @forelse($tasks as $task)
                <a href="{{ route('tasks.show', $task->id) }}" class="card">
                    <strong>{{ $task->title }}</strong><br>
                    <small>{{ $task->description }}</small><br>
                    <small>Категория: {{ $task->category->name ?? 'Без категории' }}</small><br>
                    <small>Дедлайн: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d.m.Y') : 'Не указан' }}</small><br>
                </a>
            @empty
                <div>У вас пока нет задач</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
