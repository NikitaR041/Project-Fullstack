<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //Поля
    protected $fillable = ['title', 'description', 'user_id', 'category_id', 'project_id', 'start_date', 'deadline', 'is_completed'];

    //Дополнительно для форматирование даты
    protected $casts = [ 'start_date' => 'datetime', 'deadline' => 'datetime', ];

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

    // Одна задача может принадлежать нескольким проектам (один ко многим)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    // Одна задача может иметь множество картинок (один ко многим)
    public function images()
    {
        return $this->hasMany(TaskImage::class);
    }

}
