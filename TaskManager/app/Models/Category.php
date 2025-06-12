<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Категория может содержать множество задач
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Категория может содержать множество проектов
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Новинка
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
