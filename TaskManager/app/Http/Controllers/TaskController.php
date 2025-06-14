<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Просмотр всех задач
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
                    ->with(['category', 'project'])
                    ->latest()
                    ->paginate(10);

        return view('pages.dashboard', compact('tasks'));
    }

    // Создание задачи - открывается форма
    public function create()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $categories = Category::all();

        return view('pages.tasks.form', compact('projects', 'categories'));
    }

    //Сохранение задачи - получает данные и сохраняет в бд
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255', //required - категория обязательно; В последствии может быть nullable - необязательно прописывать, но нужно редактировать польностью работу
            'project_id' => 'nullable|exists:projects,id',
            'start_date' => 'nullable|date',
            'deadline' => 'required|date|after_or_equal:start_date'
        ]);

        if (isset($validated['project_id']) && $validated['project_id']) {
            $project = Project::find($validated['project_id']);
            if ($project && $project->user_id !== Auth::id()) {
                abort(403, 'Вы не можете привязывать задачи к чужим проектам');
            }
        }

        // Вобщем то здесь есть ошибка, которую нужно исправить, т.е. пользователь вводит строку, но почему-то не присваивается id, грубо говоря, не создается строка с этим названным категорием.
        $category = Category::firstOrCreate(//Найти существующую категорию или создать новую
            ['name' => $validated['category'], 'user_id' => Auth::id()],
            ['name' => $validated['category']] // на случай firstOrCreate
        );
        $validated['category_id'] = $category->id; //Привязываем найденный или созданный ID категории
        unset($validated['category']);

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        return redirect()->route('dashboard')->with('success', 'Задача создана.');
    }

    // Просмотр одной задачи - у каждой задачи есть свои связи с "пользователем", "категорией" и "проектом" - поэтому массив
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['user', 'category', 'project']);
        $categories = Category::all();
        return view('pages.tasks.form', compact('task', 'categories'));
    }

    // Редактирование задачи
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Project::where('user_id', Auth::id())->get();
        $categories = Category::all();

        return view('pages.tasks.form', compact('task', 'projects', 'categories'));
    }

    //Сохранение изменений - связан с методом edit
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'start_date' => 'sometimes|date',
            'deadline' => 'sometimes|date|after_or_equal:start_date'
        ]);

        if (isset($validated['project_id']) && $validated['project_id']) {
            $project = Project::find($validated['project_id']);
            if ($project && $project->user_id !== Auth::id()) {
                abort(403, 'Вы не можете привязывать задачи к чужим проектам');
            }
        }

        // Найти или создать категорию
        $category = Category::firstOrCreate([
            'name' => $validated['category'], 'user_id' => Auth::id()
        ]);
        $validated['category_id'] = $category->id;

        unset($validated['category']); // Убираем, чтобы не было ошибки

        $task->update($validated);
        return redirect()->route('dashboard')->with('success', 'Задача обновлена!');
    }

    //Удаление задачи у пользователя
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        // Проверка на то, что если все карточки-задачи удалены, то удаляется и соотвутствующая категория
        $category = $task->category; // Сохраняем категорию до удаления
        $task->delete();

        // Проверяем, остались ли другие задачи с этой категорией
        if ($category && $category->user_id === Auth::id() && $category->tasks()->count() === 0) {
            $category->delete();
        }

        return redirect()->route('dashboard')->with('success', 'Задача удалена.');
    }
}
