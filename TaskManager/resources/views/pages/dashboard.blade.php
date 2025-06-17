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
</div>

<div class="dashboardmain">
    <div class="project-section scroll-container">
        <div class="section-header">
            <h2>Проекты</h2>
            <x-sort-buttons
                sortParam="project_sort"
                currentSort="{{ $projectSort ?? 'latest' }}"
                :options="[
                    'latest' => 'Новые',
                    'title' => 'По алфавиту',
                    'deadline' => 'По дедлайну'
                ]"
            />
        </div>
        <div class="cards">
            @forelse($projects as $project)
                <a href="{{ route('projects.show', $project->id) }}" class="card">
                    <strong>{{ $project->title }}</strong><br>
                    <small>{{ Str::limit($project->description, 50) }}</small><br>
                    <small>Категория: {{ $project->category->name ?? 'Без категории' }}</small>
                    @if($project->deadline)
                        <small class="deadline">📅 Дедлайн: {{ \Carbon\Carbon::parse($project->deadline)->format('d.m.Y') }}</small>
                    @endif
                </a>
            @empty
                <div class="no-items">У вас пока нет проектов</div>
            @endforelse
        </div>
    </div>

    <div class="tasks-section scroll-container">
        <div class="section-header">
            <h2>Задачи</h2>
            <x-sort-buttons
                sortParam="task_sort"
                currentSort="{{ $taskSort ?? 'latest' }}"
                :options="[
                    'latest' => 'Новые',
                    'title' => 'По алфавиту',
                    'deadline' => 'По дедлайну'
                ]"
            />
        </div>
        <div class="cards">
            @forelse($tasks as $task)
                <a href="{{ route('tasks.show', $task->id) }}" class="card">
                    <strong>{{ $task->title }}</strong><br>
                    <small>{{ Str::limit($task->description, 50) }}</small><br>
                    <small>Категория: {{ $task->category->name ?? 'Без категории' }}</small>
                    @if($task->deadline)
                        <small class="deadline">📅 Дедлайн: {{ \Carbon\Carbon::parse($task->deadline)->format('d.m.Y') }}</small>
                    @endif
                </a>
            @empty
                <div class="no-items">У вас пока нет задач</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
