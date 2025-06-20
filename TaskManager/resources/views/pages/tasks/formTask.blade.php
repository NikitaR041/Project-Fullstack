@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="form-container">
        <div class="task-header">
            <h2 class="mb-0">{{ isset($task) ? 'Редактировать задачу' : 'Создать задачу' }}</h2>
            <div class="header-body d-flex flex-wrap align-items-center gap-2">
                @if($task && is_iterable($task->images) && $task->images->isNotEmpty())
                    <form id="deleteImageForm" method="POST" onsubmit="return confirm('Удалить выбранное изображение?')" data-task-id="{{ $task->id }}">
                        @csrf
                        <div class="d-flex align-items-center gap-2">
                            <select name="image_id" id="image_id" class="form-control form-control-sm" required>
                                <option value="" disabled selected>Выбрать изображение</option>
                                @foreach ($task->images as $image)
                                    <option value="{{ $image->id }}">Изображение{{ $loop->iteration }}</option>
                                    @php
                                        $randomHeight = rand(150, 400); // от 150 до 400 пикселей
                                    @endphp
                                    <div class="image-preview-card"  style="height: {{ $randomHeight }}px;">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Изображение задачи" style="height: 100%; object-fit: cover;">
                                    </div>
                                @endforeach
                            </select>
                            <button type="submit" class="task-btn-base task-btn--delete btn-sm">
                                <img src="{{ asset('image/plagiarism.png') }}" alt="Delete">
                            </button>
                        </div>

                    </form>
                @endif
                @if(isset($task))
                    <div class="d-flex flex-column">
                        <div class="d-flex gap-2">
                            {{-- Кнопка: отметить выполненной --}}
                            <form action="{{ route('tasks.toggle-complete', $task->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="task-btn-base task-btn--default {{ $task->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $task->is_completed ? '✓ Выполнена' : 'Отметить выполненной' }}
                                </button>
                            </form>
                            {{-- Кнопка: удалить --}}
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Удалить задачу?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="task-btn-base task-btn--delete">
                                    <img src="{{ asset('image/trash.png') }}" alt="Delete">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store', $selectedProject->id ?? null) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($task)) @method('PUT') @endif

            <input type="hidden" name="project_id" value="{{ $task->project_id ?? (request('project_id') ?? $selectedProjectId ?? null) }}">

            <div class="task-fields">
                {{-- Левая панель --}}
                <div class="task-texts">
                    <div class="form-group">
                        <label for="title">Название задачи</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="category">Категория</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $task->category->name ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="deadline">Дедлайн</label>
                        <input type="date" name="deadline" class="form-control"
                               value="{{ old('deadline', isset($task->deadline) ? $task->deadline->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group d-flex gap-2 flex-wrap mt-3">
                        <button type="submit" class="task-btn-base task-btn--default">
                            <img src="{{ asset('image/' . (isset($task) ? 'magic-wand.png' : 'disk.png')) }}" alt="Save">
                            {{ isset($task) ? 'Сохранить' : 'Создать' }}
                        </button>
                        @if(isset($task) && $task->project_id)
                            <a href="{{ route('projects.show', $task->project_id) }}" class="task-btn-base task-btn--default">
                        @else
                            <a href="{{ route('dashboard') }}" class="task-btn-base task-btn--default">
                        @endif
                            <img src="{{ asset('image/arrow-alt-square-left.png') }}" alt="Back">
                            Назад
                        </a>
                        <label for="image-upload" class="task-btn-base task-btn--default">
                            {{-- <img src="{{ asset('image/add-image.png') }}" alt="Добавить изображение"> --}}
                            Загрузить фото
                        </label>

                    </div>
                </div>
                {{-- Правая панель --}}
                <div class="task-images">
                    <input type="file" name="images[]" id="image-upload" accept="image/*"
                        multiple onchange="handleImageUpload(event)" style="display: none;">

                    <div id="image-preview-container" class="image-preview-container"></div>

                    @if($task && is_iterable($task->images) && $task->images->isNotEmpty())
                        <div class="image-preview-container">
                            @foreach ($task->images as $image)
                                <div class="image-preview-card">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Изображение задачи">
                                    <p>Изображение {{ $loop->iteration }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Пока нет изображений</p>
                    @endif
                </div>
            </div>
        </form>
{{--  --}}
    </div>
</div>

@endsection

@vite('resources/js/handleTaskForm.js')
