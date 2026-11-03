<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    // Con esta función lo que haces es que, cada vez que se cree un usuario y éste cree su contraseña, ésta se hashea
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Un usuario tiene muchos proyectos. Con esta función obtenemos los datos de alguno de los proyectos que tiene el usuario. Se puede leer como "this user has many projects" "this user belongs to many projects". Solo clarificar mentalmente la forma de declararlo con código
     public function ownedProjects(): HasMany{
        return $this->hasMany(Project::class);
    }

    public function projects(): BelongsToMany{
        return $this->belongsToMany(Project::class)

            ->withPivot('role', 'contribution_hours')
            ->withTimestamps();
    }

}
