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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор проекта
            $table->string('title'); // Название проекта
            $table->text('description')->nullable(); // Описание проекта (опционально)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Привязка к пользователю
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Категория проекта (опционально)
            $table->timestamp('start_date')->nullable(); // Дата начала задачи
            $table->timestamp('deadline')->nullable(); // Дедлайн задачи
            $table->timestamps(); // Дата создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
