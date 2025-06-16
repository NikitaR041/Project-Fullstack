<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create()
    {
        return view('pages.projects.formProject');
    }

    //Просмотр всех проектов
    public function index()
    {

        $projects = Project::where('user_id', Auth::id())
                ->with('tasks')
                ->latest()
                ->get();

        // $tasks = Task::where('user_id', Auth::id())
        //             ->whereNotNull('project_id')
        //             ->with('project') // чтобы сразу подтянуть проект
        //             ->get();

        return view('pages.dashboard', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $project = Project::create($validated);

        return redirect()->route('projects.edit', $project->id)
                     ->with('success', 'Проект успешно создан!');
    }

    // Просмотр одного проекта - у каждого проекта есть свои связи с "пользователем" и "задачей" - поэтому массив
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $project->load(['user', 'tasks']);
        return view('pages.projects.formProject', compact('project'));
    }

    //Редактирование проекта
    public function edit(Project $project)
    {
        $project->load('tasks');
        return view('pages.projects.formProject', compact('project'));
    }

    //Сохранение изменений - связан с методом edit
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);
        // return response()->json($project->load(['category', 'tasks']));
        return redirect()->route('projects.edit', $project->id)->with('success', 'Проект успешно обновлён!');
    }

    //Удаление проекта
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->tasks()->delete();
        $project->delete();
        return redirect()->route('dashboard')->with('success', 'Задача удалена.');
   }
}
