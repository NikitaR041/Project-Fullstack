<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $projectSort = $request->input('project_sort', 'latest');
        $taskSort = $request->input('task_sort', 'latest');

        $projects = Project::where('user_id', Auth::id())
            ->with(['category', 'tasks'])
            ->when($projectSort === 'title', fn($q) => $q->orderBy('title'))
            ->when($projectSort === 'deadline', fn($q) => $q->orderBy('deadline'))
            ->when($projectSort === 'latest', fn($q) => $q->latest())
            ->get();

        // ЗАДАЧИ ТОЛЬКО ТЕ, которые НЕ принадлежат проектам (т.е. отдельные задачи)
        $tasks = Task::where('user_id', Auth::id())
            ->whereNull('project_id') //Фильтрация - никакого отношение к проекту
            ->with(['category', 'project'])
            ->when($taskSort === 'title', fn($q) => $q->orderBy('title'))
            ->when($taskSort === 'deadline', fn($q) => $q->orderBy('deadline'))
            ->when($taskSort === 'latest', fn($q) => $q->latest())
            ->get();

        $categories = Category::all();

        return view('pages.dashboard', compact('projects', 'tasks', 'categories', 'projectSort', 'taskSort'));
    }
}
