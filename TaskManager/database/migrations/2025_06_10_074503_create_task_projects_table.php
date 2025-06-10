<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //Это уникальная промежуточная таблица TaskProject - так как связь многие ко многим task и category
    public function up(): void
    {
        Schema::create('task_projects', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор связи
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); // Задача
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Проект
            $table->timestamps(); // Дата создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_projects');
    }
};
