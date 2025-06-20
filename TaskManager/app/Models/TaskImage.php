<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskImage extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'image_path'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Автоматическое удаление картинки из каталога storage/app/public/task_images/...
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            // Удаляем файл, если существует
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }
}
