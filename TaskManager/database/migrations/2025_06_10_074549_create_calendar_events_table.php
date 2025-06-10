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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор события
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Привязка к пользователю
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('cascade'); // Привязка к задаче (опционально)
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade'); // Привязка к проекту (опционально)
            $table->timestamp('event_date'); // Дата события
            $table->timestamps(); // Дата создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
