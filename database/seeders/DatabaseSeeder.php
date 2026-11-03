<?php

namespace Database\Seeders;


// Los Seeders (o Database Seeders) son clases de PHP que sirven única y exclusivamente para llenar tu base de datos con datos de prueba o iniciales. Esta clase es como el orquestador, desde aquí se ejecuta la lógica de cada seeder individual de cada modelo. O sea, en cada archivo declaras lógica de cómo se generan los datos. Aquí simplemente se generan y ya.

use App\Models\User;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // User::factory(10)->create();
    }
}
