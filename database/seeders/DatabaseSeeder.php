<?php

namespace Database\Seeders;


// Los Seeders (o Database Seeders) son clases de PHP que sirven única y exclusivamente para llenar tu base de datos con datos de prueba o iniciales. Esta clase es como el orquestador, desde aquí se ejecuta la lógica de cada seeder individual de cada modelo. El único trabajo de esta clase es organizar el orden en el que se van a ejecutar los seeders de cada modelo.

// En cada seeder(que se compone de, por ejemplo del modelo project, tendrías -> projectFactory + projectSeeder) declararía el cómo se hacen los datos (factory) y la cantidad (seeder).

use App\Models\User;
use App\Models\Project;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Esto lo que hace es que genera x instancias de prueba aleatoriamente con la estructura de datos que tenga la tabla de la clase, en este caso, users
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $users = User::factory(10)->create();

        // 2. Crear 10 proyectos usando el Factory
        $projects = Project::factory(10)->create([
            // Forzamos que el dueño (user_id) sea aleatorio entre los 5 usuarios creados antes
            'user_id' => $users->random()->id,
        ]);

        // 3. Recorrer cada proyecto para asignarle colaboradores en la tabla pivote
        foreach ($projects as $project) {
            // Seleccionamos entre 2 y 4 usuarios aleatorios que no sean necesariamente el dueño
            $colaboradores = $users->random(rand(2, 4));

            foreach ($colaboradores as $user) {
                // Usamos el método attach() para guardar en la tabla intermedia con datos extra. aprovechamos el segundo argumento (el array) para inyectar los datos de los campos extra.
                
                $project->users()->attach($user->id, [
                    'role' => fake()->randomElement(['Desarrollador', 'Diseñador', 'Tester']),
                    'contribution_hours' => fake()->numberBetween(5, 40),
                ]);
            }
        }
    }
    
}