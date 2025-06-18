<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор задачи
            $table->string('title'); // Название задачи
            $table->text('description')->nullable(); // Описание задачи (опционально)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Привязка к пользователю
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade'); // Принадлежность проекту - constrained ограничитель
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Категория задачи (опционально)
            $table->timestamp('start_date')->nullable(); // Дата начала задачи
            $table->timestamp('deadline')->nullable(); // Дедлайн задачи
            $table->boolean('is_completed')->default(false);
            $table->timestamps(); // Дата создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
