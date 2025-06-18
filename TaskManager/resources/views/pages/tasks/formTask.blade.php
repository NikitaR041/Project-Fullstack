@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>{{ isset($task) ? 'Редактировать задачу' : 'Создать задачу' }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Основная форма создания/редактирования задачи --}}
    <form
        action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store', $selectedProject->id ?? null) }}"method="POST">
        @csrf
        @if(isset($task))
            @method('PUT')
        @endif

        <input type="hidden" name="project_id" value="{{ $task->project_id ?? (request('project_id') ?? $selectedProjectId ?? null) }}">

        <div class="form-group mb-3">
            <label for="title">Название задачи</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Описание</label>
            <textarea name="description" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="category">Категория</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $task->category->name ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="deadline">Дедлайн</label>
            <input type="date" name="deadline" class="form-control"
                   value="{{ old('deadline', isset($task->deadline) ? $task->deadline->format('Y-m-d') : '') }}">
        </div>

        {{-- Кнопки: Сохранить / Назад (в одной строке) --}}
        <div class="d-flex gap-2 mb-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($task) ? 'Сохранить изменения' : 'Создать задачу' }}
            </button>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Назад</a>
        </div>
    </form>

        @if(isset($task))

        @endif

    {{-- Форма удаления задачи (отдельно, только если задача уже существует) --}}
    @if(isset($task))
        <form action="{{ route('tasks.toggle-complete', $task->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn {{ $task->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                {{ $task->is_completed ? '✓ Выполнена' : 'Отметить выполненной' }}
            </button>
        </form>
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Удалить задачу?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить задачу</button>
        </form>
    @endif
</div>
@endsection
