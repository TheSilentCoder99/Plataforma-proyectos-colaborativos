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
        // tabla de unión entre proyectos y usuarios
        Schema::create('project_users', function (Blueprint $table) {

            // id del usuario
            $table->foreignId('users')->constrained()->cascadeOnDelete();

            // id del proyecto
            $table->foreignId('projects')->constrained()->cascadeOnDelete();

            // Cuando el usuario se esté apuntando a un proyecto, a través de su propio id es como determinas qué rol tiene.
            $table->string('role');

            $table->integer('contribution_hours');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_users');
    }
};
