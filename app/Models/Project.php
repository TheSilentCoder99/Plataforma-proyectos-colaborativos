<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    
    // modelo de datos de la tabla proyectos

    // El array fillable me indica todas las propiedades de la tabla que se pueden asignar. O sea, propiedades que pueden recibir su asignación desde, por ejemplo, la entrada de un formulario.
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
    ];

    // Definición de una relación (ejemplo: un proyecto pertenece a un usuario). Con esta función obtenemos datos del usuario dueño de este proyecto.
    public function owner(): BelongsTo {
        // Le estás diciendo a Laravel: "Oye, quiero que este método se llame owner en PHP, pero no busques owner_id en MySQL; la clave foránea real es user_id".

        // Laravel siempre intenta adivinar la columna usando el nombre del método más _id
        return $this->belongsTo(User::class,'user_id');
    }
    

    // Devuelve todos los usuarios involucrados en este proyecto
        public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)

            ->withPivot('role', 'contribution_hours')
            ->withTimestamps();
    }



}
