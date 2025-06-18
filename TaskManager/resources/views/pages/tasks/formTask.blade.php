@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="form-container">
        {{-- Левая панель: форма --}}
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
                </div>
                {{-- Правая панель --}}
                <div class="task-images">
                    <label for="image" class="image-label">📁 Загрузить изображение</label>
                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">

                    @if(isset($task) && $task->image)
                        <img id="imagePreview" class="image-preview" src="{{ asset('storage/' . $task->image) }}" alt="Preview">
                    @else
                        <img id="imagePreview" class="image-preview" src="#" alt="Preview" style="display: none;">
                    @endif
                </div>
                {{-- Это вроде возможность добавить несколько фото --}}
                {{-- <div class="task-images">
                    <label for="image-upload" class="image-upload-btn">
                        <img src="{{ asset('image/add-image.png') }}" alt="Добавить изображение">
                        Загрузить фото
                    </label>
                    <input type="file" name="images[]" id="image-upload" accept="image/*"
                        multiple onchange="handleImageUpload(event)" style="display: none;">

                    <div id="image-preview-container" class="image-preview-container"></div>
                </div> --}}
            </div>

            <div class="form-group d-flex gap-2 flex-wrap mt-3">
                <button type="submit" class="task-btn-base task-btn--default">
                    <img src="{{ asset('image/' . (isset($task) ? 'magic-wand.png' : 'disk.png')) }}" alt="Save">
                    {{ isset($task) ? 'Сохранить' : 'Создать' }}
                </button>
                <a href="{{ route('dashboard') }}" class="task-btn-base task-btn--default">
                    <img src="{{ asset('image/arrow-alt-square-left.png') }}" alt="Back">
                    Назад
                </a>
            </div>
        </form>

        @if(isset($task))
            <div class="">
                <form action="{{ route('tasks.toggle-complete', $task->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="task-btn-base task-btn--default {{ $task->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                        {{ $task->is_completed ? '✓ Выполнена' : 'Отметить выполненной' }}
                    </button>
                </form>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Удалить задачу?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="task-btn-base task-btn--delete">
                        <img src="{{ asset('image/trash.png') }}" alt="Delete"> Удалить </button>
                </form>
            </div>
        @endif

    </div>
</div>

{{-- Если будем вставлять несколько картинок, то меняем этот скрипт
Также меняем TaskConrtoller - ограничение на картинок (примерно 10 картинок), размер картинок (наверное 1000на1000 пикселей)
А также добавить новую модель с миграцией(таблицей) --}}

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
