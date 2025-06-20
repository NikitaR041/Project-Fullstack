@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <div class="dashboardheader">
        <div class="header-left">
            <a href="{{ route('tasks.create') }}" class="header-button">
                <img src="{{ asset('image/task-checklist.png') }}" alt="Создать задачу">
                <span>Создать задачу</span>
            </a>
            <a href="{{ route('projects.create') }}" class="header-button">
                <img src="{{ asset('image/master-plan.png') }}" alt="Создать проект">
                <span>Создать проект</span>
            </a>
            <a href="#" class="header-button">
                <img src="{{ asset('image/calendar.png') }}" alt="Расписание">
                <span>Расписание</span>
            </a>
        </div>

        <div class="header-right">
            <div class="user-info">
                <img src="{{ asset('image/user.png') }}" alt="Профиль" class="icon">
                <span>{{ Auth::user()->name }}</span>
            </div>
            <a href="{{ route('logout') }}" class= "header-button">
                <img src="{{ asset('image/leave.png') }}" alt="Выход" class="icon">
            </a>
        </div>
    </div>

    <div class="dashboardmain-columns">
        {{-- Левая колонка — ПРОЕКТЫ --}}
        <div class="column-block">
            <div class="section-header">
                <h2>Проекты</h2>
                <div class="filter-bar">
                    <!-- Иконка фильтра категорий -->
                    <div class="dropdown">
                        <img src="{{ asset('image/category.png') }}" class="icon" onclick="toggleDropdown('project-dropdown')" alt="Фильтр по категориям">
                        <div id="project-dropdown" class="dropdown-menu">
                            <!-- В блоке проектов -->
                            @if(isset($projectCategories) && count($projectCategories) > 0)
                                <a href="{{ route('dashboard', ['project_category' => 'all']) }}">Все категории</a>
                                @foreach($projectCategories as $category)
                                    <a href="{{ route('dashboard', ['project_category' => $category->id]) }}">{{ $category->name }}</a>
                                @endforeach
                            @else
                                <span class="dropdown-empty">Категории отсутствуют</span>
                            @endif
                        </div>
                    </div>

                    <!-- КОМПОНЕНТ СОРТИРОВКИ -->
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
            </div>
            <div class="cards">
                @forelse($projects as $project)
                    <a href="{{ route('projects.show', $project->id) }}" class="card">
                        <strong>{{ $project->title }}</strong><br>
                        <small>{{ Str::limit($project->description, 10) }}</small><br>
                        <small>Категория: {{ $project->category->name ?? 'Без категории' }}</small>
                        @if($project->deadline)
                            <small class="deadline">📅 {{ \Carbon\Carbon::parse($project->deadline)->format('d.m.Y') }}</small>
                        @endif
                    </a>
                @empty
                    <div class="no-items">Нет проектов</div>
                @endforelse
            </div>
        </div>

        {{-- Правая колонка — ЗАДАЧИ --}}
        <div class="column-block">
            <div class="section-header">
                <h2>Задачи</h2>
                <div class="filter-bar">
                    <!-- Иконка фильтра категорий -->
                    <div class="dropdown">
                        <img src="{{ asset('image\category.png') }}" class="icon" onclick="toggleDropdown('task-dropdown')" alt="Фильтр по категориям">
                        <div id="task-dropdown" class="dropdown-menu">
                            @if(isset($taskCategories) && count($taskCategories) > 0)
                                <a href="{{ route('dashboard', ['task_category' => 'all']) }}">Все категории</a>
                                @foreach($taskCategories as $category)
                                    <a href="{{ route('dashboard', ['task_category' => $category->id]) }}">{{ $category->name }}</a>
                                @endforeach
                            @else
                                <span class="dropdown-empty">Категории отсутствуют</span>
                            @endif
                        </div>
                    </div>

                    <!-- КОМПОНЕНТ СОРТИРОВКИ -->
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
            </div>
            <div class="cards">
                @forelse($tasks as $task)
                    <div class="card {{ $task->is_completed ? 'completed' : '' }}">
                        <a href="{{ route('tasks.show', $task->id) }}">
                            <strong>{{ $task->title }}</strong><br>
                            <small>{{ Str::limit($task->description, 10) }}</small><br>
                            <small>Категория: {{ $task->category->name ?? 'Без категории' }}</small>
                            @if($task->deadline)
                                <small class="deadline">📅 {{ \Carbon\Carbon::parse($task->deadline)->format('d.m.Y') }}</small>
                            @endif
                        </a>
                        <form action="{{ route('tasks.toggle-complete', $task->id) }}" method="POST" class="complete-form">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $task->is_completed ? 'btn-success' : 'btn-outline-secondary' }}">
                                {{ $task->is_completed ? '✓' : '◻' }}
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="no-items">Нет задач</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- скрипт для выпадение списка категорий --}}
<script>
    function toggleDropdown(id) {
        const menu = document.getElementById(id);
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    document.addEventListener('click', function(event) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (!menu.parentElement.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    });
</script>


@endsection
