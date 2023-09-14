<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();

            $table->string('original_url')
                ->comment('Оригинальный URL');
            $table->string('shortened_url')
                ->unique()
                ->comment('Короткий URL');
            $table->string('name')
                ->nullable()
                ->comment('Имя ссылки');
            $table->unsignedInteger('visits')
                ->default(0)
                ->comment('Количество посещений');

            $table->foreignId('user_id')
                ->comment('ID пользователя')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
