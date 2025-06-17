@extends('layouts.app')

@section('content')
<div class="project-container" style="padding: 20px; max-width: 800px; margin: auto;">

    <h2>{{ isset($project) ? 'Редактирование проекта' : 'Создание проекта' }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Форма создания/редактирования проекта --}}
    <form
        action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}" method="POST" style="margin-bottom: 30px;">
        @csrf
        @if(isset($project))
            @method('PUT')
        @endif

        <div style="form-group mb-3">
            <label for="title">Название проекта</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $project->title ?? '') }}" required style="margin-bottom: 30px">
        </div>

        <div class="form-group mb-3">
            <label for="category">Категория</label>
            <input type="text" name="category" class="form-control"
                value="{{ old('category', $project->category->name ?? '') }}" required>
        </div>

        <div style="form-group mb-3">
            <label for="title">Описание</label>
            <input type="text" name="description" class="form-control" value="{{ old('description', $project->description ?? '') }}" required style="margin-bottom: 30px">
        </div>

        <div class="form-group mb-3">
            <label for="deadline">Дедлайн</label>
            <input type="date" name="deadline" class="form-control"
                   value="{{ old('deadline', isset($project->deadline) ? $project->deadline->format('Y-m-d') : '') }}">
        </div>

        <div style="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                {{ isset($project) ? 'Сохранить изменения' : 'Создать проект' }}
            </button>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary"> Выйти на рабочий стол</a>

            @if(isset($project))
                {{-- Показываем кнопку добавления объекта-задачи только если объект-проект уже существует --}}
                <a class="btn btn-secondary"  href="{{ route('tasks.create', ['project_id' => $project->id]) }}">
                    Добавить задачу
                </a>

            @endif
        </div>
    </form>
    {{-- Показываем кнопку удаления только если задача уже существует --}}
    @if(isset($project))
        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Удалить проект?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
    @endif

    {{-- Список задач, если проект уже существует --}}
    @if(isset($project) && $project->tasks->count())
        <hr>
        <h3>Задачи проекта</h3>

        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
            @foreach($project->tasks as $task)
                <div style="padding: 10px; margin-bottom: 8px; background: #f5f5f5; border-radius: 5px;">
                    <a href="{{ route('tasks.edit', $task->id) }}" style="text-decoration: none; color: black;">
                        {{ $task->title }}
                    </a>
                </div>
            @endforeach
        </div>
    @elseif(isset($project))
        <p>Задачи ещё не добавлены.</p>
    @endif


</div>
@endsection
