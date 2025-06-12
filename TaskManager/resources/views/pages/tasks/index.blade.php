@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Ваши задачи</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tasks->count())
        <div class="row">
            @foreach($tasks as $task)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text">{{ $task->description }}</p>
                            <p class="card-text">
                                Категория: {{ $task->category->name ?? 'Без категории' }}<br>
                                Проект: {{ $task->project->name ?? 'Без проекта' }}
                            </p>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Удалить задачу?')" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $tasks->links() }}
        </div>
    @else
        <p>У вас пока нет задач.</p>
    @endif

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-3">Создать задачу</a>
</div>
@endsection
