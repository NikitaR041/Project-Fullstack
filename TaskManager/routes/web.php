<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('pages.cover');
})->name('home');

// Для неавторизованных гостей
Route::middleware(['guest'])->group(function() {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Для авторизованных гостей
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD - объектов-задач
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index'); // список задач
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // форма создания
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); // отправка формы
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show'); // просмотр задачи
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit'); // редактирование
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update'); // сохранение редактирования
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy'); // удаление задачи
    Route::post('/tasks/{task}/toggle-complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggle-complete'); //Переключение статуса выполнения задачи
    Route::delete('/tasks/{task}/images/{image}', [TaskController::class, 'deleteImage'])->name('tasks.deleteImage'); //Удаление изображения

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index'); // список проектов
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create'); // форма создания
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store'); // отправка формы
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show'); // просмотр проекта
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit'); // редактирование
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update'); // сохранение редактирования
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy'); // удаление проекта

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.form');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



