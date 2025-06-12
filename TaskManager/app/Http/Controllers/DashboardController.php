<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
                    ->with(['category', 'project'])
                    ->latest()
                    ->get();
        $categories = Category::all();

        return view('pages.dashboard', compact('tasks', 'categories'));
    }
}
