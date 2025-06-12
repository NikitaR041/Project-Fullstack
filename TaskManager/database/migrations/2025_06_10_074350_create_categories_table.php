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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор категории
            $table->string('name')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //Связь с users
            $table->timestamps(); // Дата создания и обновления записи

            // Уникальность названия категории только для конкретного пользователя
            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
