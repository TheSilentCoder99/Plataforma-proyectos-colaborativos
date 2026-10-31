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
        // tabla proyectos
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            
            // propietario del proyecto (relación 1:N)
            // Cuando esté definiendo las relaciones de las tablas en los modelos, laravel va a venir aquí a buscar la relación
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title');

            $table->text('description');

            $table->date('due_date');

            // Esto debe venir de un campo cerrado en el frontend
            $table->string('status');

            $table->timestamps();
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
