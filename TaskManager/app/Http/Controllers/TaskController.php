<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Просмотр всех задач
    public function index()
    {
        // $tasks = Auth::user()->tasks()
        $tasks = Task::where('user_id', Auth::id())
                    ->with(['category', 'project'])
                    ->latest()
                    ->paginate(10);

        // return view('pages.tasks.index', compact('tasks'));
        // return view('pages.tasks.form', compact('tasks'));
        return view('pages.dashboard', compact('tasks'));
    }

    // Создание задачи - открывается форма
    public function create()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $categories = Category::all();

        // return view('pages.tasks.create', compact('projects', 'categories'));
        return view('pages.tasks.form', compact('projects', 'categories'));
    }

    //Сохранение задачи - получает данные и сохраняет в бд
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|string|max:255', //required - категория обязательно; В последствии может быть nullable - необязательно прописывать, но нужно редактировать польностью работу
            'project_id' => 'nullable|exists:projects,id',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date'
        ]);

        // // Найти или создать категорию
        // if ($validated['category']) {
        //     $category = Category::firstOrCreate(['name' => $validated['category']]);
        //     $validated['category_id'] = $category->id;
        // }

        // Вобщем то здесь есть ошибка, которую нужно исправить, т.е. пользователь вводит строку, но почему-то не присваивается id, грубо говоря, не создается строка с этим названным категорием.
        $category = Category::firstOrCreate(['name' => $validated['category']]); //Найти существующую категорию или создать новую
        $validated['category_id'] = $category->id; //Привязываем найденный или созданный ID категории

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        // return redirect()->route('tasks.index')->with('success', 'Задача создана.');
        // return redirect()->route('pages.tasks.form')->with('success', 'Задача создана.');
        return redirect()->route('dashboard')->with('success', 'Задача создана.');
    }

    // Просмотр одной задачи - у каждой задачи есть свои связи с "пользователем", "категорией" и "проектом" - поэтому массив
    public function show(Task $task)
    {
        $task->load(['user', 'category', 'project']);
        $categories = Category::all();
        // return view('pages.tasks.show', compact('task'));
        return view('pages.tasks.form', compact('task', 'categories'));
    }

    // Редактирование задачи
    public function edit(Task $task)
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $categories = Category::all();

        // return view('pages.tasks.edit', compact('task', 'projects', 'categories'));
        return view('pages.tasks.form', compact('task', 'projects', 'categories'));
    }

    //Сохранение изменений - связан с методом edit
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'nullable|exists:categories,id',
            'project_id' => 'nullable|exists:projects,id',
            'start_date' => 'sometimes|date',
            'deadline' => 'sometimes|date|after_or_equal:start_date'
        ]);

        $task->update($validated);
        // return redirect()->route('tasks.index')->with('success', 'Задача обновлена.');
        // return redirect()->route('pages.tasks.form')->with('success', 'Задача обновлена.');
        return redirect()->route('dashboard')->with('success', 'Задача обновлена!');
    }

    //Удаление задачи у пользователя
    public function destroy(Task $task)
    {
        $task->delete();
        // return redirect()->route('tasks.index')->with('success', 'Задача удалена.');
        // return redirect()->route('pages.tasks.form')->with('success', 'Задача удалена.');
        return redirect()->route('dashboard')->with('success', 'Задача удалена.');
    }
}
