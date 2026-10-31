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
        Schema::create('project_user', function (Blueprint $table) {

            // id del usuario
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // id del proyecto
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('role');

            // un usuario no puede estar dos veces en el mismo proyecto
            $table->unique(['user_id', 'project_id']); 

            $table->integer('contribution_hours')->default(0);

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};
