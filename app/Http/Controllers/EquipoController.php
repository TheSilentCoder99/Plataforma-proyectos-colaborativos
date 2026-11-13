<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class EquipoController extends Controller
{

public $project;
public $users;


public function __construct() {

    $this->project = new Project();
    $this->users = new User();

}
    
// Métodos relacionados con la ventana dedicada a la gestión del equipo
// Creo este controlador nuevo para no mezclar lógica del manejo de proyectos con el manejo del equipo


// Mostrar la ventana de edición del equipo y enviar datos para su construcción dinámica

public function showteam(Project $project)
{

/*
load() carga la relación en un modelo que ya tienes (el que el Route Model Binding te dio), para que $project->users esté disponible sin consultas extra al recorrerla. Devuelve el mismo $project, ya con la relación cargada.
Es la versión “después” de with('users'), que se usa antes de buscar:
Project::with('users')->find($id);   // with: al buscar
$project->load('users');             // load: sobre un modelo ya existente
*/

    // Si traigo solamente los colaboradores que NO están en el proyecto, evito algunos problemas de duplicidad.

    $project->load('users');

    /*pluck('id') convierte la colección de usuarios del proyecto en una colección solo de ids (por ejemplo [2, 5, 7]).
whereNotIn('id', ...) es una condición de consulta: “usuarios cuyo id no esté en esa lista”. Como ahora trabajas sobre User:: (el constructor de consultas), necesitas el ->get() final. Es decir, esto dice: "dame todos los ids no estén contenidos en esta lista"*/
    $disponibles = User::whereNotIn('id', $project->users->pluck('id'))->get();

    // Al enviar la vista, explicíto lo que contiene cada variable que allí se usará
    return view('views_project.gestionar_equipo', [
        'ProyectoRecibeUser' => $project,
        'todosUsers' => $disponibles,
    ]);
}


// Agregar un colaborador
public function agregarUser(Request $request, Project $project)
{
    
    $validated = $request->validate([
        'id' => 'required|exists:users,id',
        'role' => ['required','string', Rule::in(['Desarrollador backend', 'Desarrollador frontend', 'Scrum Master', 'Project Manager','Diseñador UX/UI','Desarrollador Full-Stack','Ingeniero QA','Ingeniero DevOps','Product Owner'])],
        'contribution_hours' => 'required|integer|min:0'
    ]);

    // Para que el servidor de base de datos no se queje, siempre que hagas un attach() o un syncWithoutDetaching() debes suministrar todos los valores obligatorios de esa tabla intermedia. Al ingresar los datos, en el HTML, ponle los nombres de las columnas receptoras al name e id para que SQL no te rechace las inserciones.
  $project->users()->syncWithoutDetaching([
        $validated['id'] => [
            'role' => $validated['role'],
            'contribution_hours' => $validated['contribution_hours']
        ]
    ]);

    return redirect()->route('projects.edit', $project)
        ->with('success', 'Colaborador agregado correctamente.');
}



// Eliminar un colaborador
public function borrarUser(Request $request, Project $project)
{
    $validated = $request->validate(['id' => 'required|exists:users,id']);

    // Para quitar a un usuario del proyecto, con darle a detach su id, es suficiente. También acepta el modelo completo, más fácil.
  $project->users()->detach(
        $validated['id']);

    return redirect()->route('projects.edit',$project)
        ->with('success', 'Colaborador eliminado correctamente.');
}




}
