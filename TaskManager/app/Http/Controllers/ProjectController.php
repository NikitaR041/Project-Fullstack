<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with(['category', 'tasks'])
            ->where('user_id', Auth::id())->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $validated['user_id'] = Auth::id();
        $project = Project::create($validated);

        return response()->json($project->load(['category', 'tasks']), 201);
    }

    public function show(Project $project)
    {
        return $project->load(['category', 'tasks']);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $project->update($validated);
        return response()->json($project->load(['category', 'tasks']));
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
