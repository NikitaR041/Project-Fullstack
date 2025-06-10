<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    // Разрешенные для массового заполнения поля
    protected $fillable = ['name', 'email', 'password'];

    // Один пользователь может иметь множество задач
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Один пользователь может иметь множество проектов
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Один пользователь может иметь множество событий в календаре
    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
