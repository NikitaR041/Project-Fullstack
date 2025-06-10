<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task_id', 'project_id', 'event_date'];

    // Событие принадлежит пользователю
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Событие может быть связано с задачей (опционально)
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Событие может быть связано с проектом (опционально)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
