<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //Поля
    protected $fillable = ['title', 'description', 'user_id', 'category_id', 'start_date', 'deadline'];

    // Задача принадлежит одному пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Задача принадлежит одной категории (если назначена)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Одна задача может принадлежать нескольким проектам (многие ко многим)
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'task_project');
    }
}
