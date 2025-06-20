<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TaskManager')</title>
     {{-- JavaScript (AJAX) для редактирования и удаления задач --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources\css\app.scss'])

</head>
<body>
    {{-- Голова --}}
    {{-- <header>
    </header> --}}

    {{-- Основа --}}
    <main>
        @yield('content')
    </main>

    {{-- Подвал --}}
    <footer class="site-footer">
            <div class="container">
            </div>
    </footer>
</body>
</html>
