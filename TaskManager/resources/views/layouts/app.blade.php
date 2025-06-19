<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TaskManager')</title>
     {{-- JavaScript (AJAX) для редактирования и удаления задач --}}
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources\css\app.css'])
    @vite(['resources\css\register.css'])
    @vite(['resources\css\dashboard.css'])
    @vite(['resources\css\form.css'])

</head>
<body>
    {{-- Голова --}}
    <header>
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
    </header>

    {{-- Основа --}}
    <main>
        @yield('content')
    </main>

    {{-- Подвал --}}
    <footer class="site-footer">
            <div class="container">
                {{-- Необязательно такое прописывать --}}
                {{-- &copy; 2025 MyProject --}}
            </div>
    </footer>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- @if(app()->environment('local'))
        @vite(['resources/js/app.js']) <!-- Для разработки -->
    @else
        <script src="{{ asset('js/app.js') }}"></script> <!-- Для продакшена -->
    @endif
    @stack('scripts') --}}
    {{-- <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts') --}}
</body>
</html>
