<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = Auth::user()->tasks()
                    ->with(['category', 'project'])
                    ->latest()
                    ->paginate(10);

        return view('pages.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $categories = Category::all();

        return view('pages.tasks.create', compact('projects', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'project_id' => 'nullable|exists:projects,id',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date'
        ]);

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Задача создана.');
    }

    public function show(Task $task)
    {
        $task->load(['user', 'category', 'project']);
        return view('pages.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $categories = Category::all();

        return view('pages.tasks.edit', compact('task', 'projects', 'categories'));
    }

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
        return redirect()->route('tasks.index')->with('success', 'Задача обновлена.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Задача удалена.');
    }
}
