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
        // Фильтрация по "Новые", "По Алфавиту", "По дедлайну"
        $projectSort = $request->input('project_sort', 'latest');
        $taskSort = $request->input('task_sort', 'latest');
        // Фильтарция по "Категориям"
        $projectCategoryId = $request->input('project_category');
        $taskCategoryId = $request->input('task_category');

        $projects = Project::where('user_id', Auth::id())
            ->with(['category', 'tasks'])
            ->when($projectCategoryId && $projectCategoryId !== 'all', fn($q) => $q->where('category_id', $projectCategoryId))
            ->when($projectSort === 'title', fn($q) => $q->orderBy('title'))
            ->when($projectSort === 'deadline', fn($q) => $q->orderBy('deadline'))
            ->when($projectSort === 'latest', fn($q) => $q->latest())
            ->get();

        // ЗАДАЧИ ТОЛЬКО ТЕ, которые НЕ принадлежат проектам (т.е. отдельные задачи)
        $tasks = Task::where('user_id', Auth::id())
            ->whereNull('project_id') //Фильтрация - никакого отношение к проекту
            ->with(['category', 'project'])
            ->when($taskCategoryId && $taskCategoryId !== 'all', fn($q) => $q->where('category_id', $taskCategoryId))
            ->when($taskSort === 'title', fn($q) => $q->orderBy('title'))
            ->when($taskSort === 'deadline', fn($q) => $q->orderBy('deadline'))
            ->when($taskSort === 'latest', fn($q) => $q->latest())
            ->get();

        // Фильтрация по текущему пользователю - безопасно так
        $categories = Category::where('user_id', Auth::id())->get();

        // Это работает только если у категории уже есть проекты или задачи. Но если категория создана и пока пуста — она не попадёт ни в один список
        $projectCategories = $categories->filter(fn($cat) => $cat->projects->count() > 0);
        $taskCategories = $categories->filter(fn($cat) => $cat->tasks->count() > 0);

        return view('pages.dashboard', compact('projects', 'tasks', 'projectCategories', 'taskCategories', 'projectSort', 'taskSort'));
    }
}
