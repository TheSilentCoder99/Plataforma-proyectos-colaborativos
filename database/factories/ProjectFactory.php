<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3), 
            'description' => fake()->paragraph(),
            'due_date' => fake()->dateTimeBetween('now', '+6 months'),
            'status' => fake()->randomElement(['pendiente', 'en_progreso', 'completado']),
            'user_id' => User::factory(), // Asocia un usuario creador por defecto
        ];
    }
}