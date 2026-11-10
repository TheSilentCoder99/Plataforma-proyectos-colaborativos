<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    
// Métodos relacionados con la ventana dedicada a la gestión del equipo
// Creo este controlador nuevo para no mezclar lógica del manejo de proyectos con el manejo del equipo


// Mostrar la ventana de edición del equipo

public function showteam(){

    return view('views_project.gestionar_equipo');

}


// Agregar un colaborador
public function agregarUser(Request $request, Project $project)
{
    $validated = $request->validate([
        'id' => 'required|exists:users,id',
        'role' => 'required|string|', Rule::in(['Desarrollador backend', 'Desarrollador frontend', 'Scrum Master', 'Project Manager','Diseñador UX/UI','Desarrollador Full-Stack','Ingeniero QA','Ingeniero DevOps','Product Owner']),
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
        ->with('success', 'Usuario agregado correctamente.');
}



// Eliminar un colaborador
public function borrarUser(Request $request)
{
    $validated = $request->validate(['id']);

    // Para que el servidor de base de datos no se queje, siempre que hagas un attach() o un syncWithoutDetaching() debes suministrar todos los valores obligatorios de esa tabla intermedia. Al ingresar los datos, en el HTML, ponle los nombres de las columnas receptoras al name e id para que SQL no te rechace las inserciones.

  $project->users()->detach([
        $validated['id']]);

    return redirect()->route('projects.edit')
        ->with('success', 'Usuario eliminado correctamente.');
}




}
