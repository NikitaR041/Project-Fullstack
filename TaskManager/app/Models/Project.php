<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    //Поля
    protected $fillable = ['name', 'description', 'user_id', 'category_id'];

    // Проект принадлежит одному пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Проект принадлежит одной категории (если назначена)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Проект может содержать много задач (многие ко многим)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
