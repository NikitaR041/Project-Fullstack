<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    //Поля
    // protected $fillable = ['title', 'description', 'user_id', 'category_id'];
    // Не нужно нам поле category_id
    protected $fillable = ['title', 'description', 'user_id', 'category_id', 'start_date', 'deadline'];

    //Дополнительно для форматирование даты
    protected $casts = [ 'start_date' => 'datetime', 'deadline' => 'datetime', ];

    public function getProgressAttribute() {
        if($this->tasks->isEmpty()) {
            return 0;
        }

        $completed = $this->tasks->where('is_completed', true)->count();
        $total = $this->tasks->count();

        return round(($completed / $total) * 100);
    }

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
