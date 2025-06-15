<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())
                        ->with('tasks')
                        ->latest()
                        ->get();

        // ЗАДАЧИ ТОЛЬКО ТЕ, которые НЕ принадлежат проектам (т.е. отдельные задачи)
        $tasks = Task::where('user_id', Auth::id())
                    ->whereNull('project_id') //Фильтрация - никакого отношение к проекту
                    ->with(['category', 'project'])
                    ->latest()
                    ->get();

        $categories = Category::all();

        return view('pages.dashboard', compact('projects', 'tasks', 'categories'));
    }
}
