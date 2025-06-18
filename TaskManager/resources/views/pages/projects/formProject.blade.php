@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        {{-- Левая часть: форма --}}
        <div class="col-md-6 mb-4">
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

            <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}" method="POST">
                @csrf
                @if(isset($project))
                    @method('PUT')
                @endif

                <div class="form-group mb-3">
                    <label for="title">Название проекта</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $project->title ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="category">Категория</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $project->category->name ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Описание</label>
                    <input type="text" name="description" class="form-control" value="{{ old('description', $project->description ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="deadline">Дедлайн</label>
                    <input type="date" name="deadline" class="form-control"
                        value="{{ old('deadline', isset($project->deadline) ? $project->deadline->format('Y-m-d') : '') }}">
                </div>

                <div class="d-flex gap-2 flex-wrap mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($project) ? 'Сохранить изменения' : 'Создать проект' }}
                    </button>

                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Назад</a>

                    @if(isset($project))
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn btn-secondary">
                            Добавить задачу
                        </a>
                    @endif
                </div>
            </form>

            @if(isset($project))
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Удалить проект?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить проект</button>
                </form>
            @endif
        </div>

        {{-- Правая часть: карточки задач --}}
        <div class="col-md-6">
            <h3>Задачи проекта</h3>
            @if(isset($project) && $project->tasks->count())
            <div class="cards">
                @foreach($project->tasks as $task)
                    <div class="card">
                        <a href="{{ route('tasks.edit', $task->id) }}" style="text-decoration: none; color: inherit;">
                            <h5>{{ $task->title }}</h5>
                            <p>{{ Str::limit($task->description, 80) }}</p>
                            @if($task->deadline)
                                <small>⏳ до {{ \Carbon\Carbon::parse($task->deadline)->format('d.m.Y') }}</small>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            @else
                <p>Задачи ещё не добавлены.</p>
            @endif
        </div>
    </div>
</div>
@endsection
