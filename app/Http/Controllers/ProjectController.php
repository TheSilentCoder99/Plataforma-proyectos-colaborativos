<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public Project $project;

    public User $users;

    public function __construct()
    {
        $this->project = new Project();
        $this->users = new User();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $proyectos = $this->project->all();
        

        return view('views_project.index_project', compact('proyectos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('views_project.crear_proyecto');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|',
            'due_date' => 'required|date',
            'status' => 'required',Rule::in(['terminado', 'activo', 'cancelado', 'pausado'])
        ]);

         // De esta manera puedo pasarle el id al método de creación. NUNCA directamente en el HTML: genera problemas de seguridad.

        // Básicamente, esto toma el id del usuario autenticado (que Laravel ya conoce porque le crea un token asociado a su tabla en User) y lo mete al parámetro de validatedData. En resumen, cuando quieras sacar el id del usuario actual, sácalo de aquí.

         $validatedData['user_id'] = auth()->id();

    
        /*
        Otra manera de hacer lo mismo (aunque se entiende peor):
        auth()->user()->projects()->create($validatedData);

    como si leyéramos la frase de izquierda a derecha gracias a la magia de Eloquent (el ORM de Laravel):

    auth()->user(): "Oye, Laravel, dame el modelo de Eloquent del usuario que ha iniciado sesión en este momento exacto."

    ->projects(): "Entra en su relación de proyectos" (haciendo referencia al método hasMany(Project::class) que deberías tener definido en tu modelo User).

    ->create($validatedData): "Crea un nuevo registro en la base de datos pasándole estos datos validados..." y aquí viene el superpoder: Laravel es tan listo que, como estás llamando al método create desde el usuario, coge el ID de ese usuario y lo inyecta automáticamente como user_id en la tabla projects sin que tengas que añadírselo tú a mano.*/

        $project = Project::create($validatedData);

        // Redirijo a la lista de todos los proyectos con un mensaje
        return redirect()->route('dashboard')->with('success', 'Proyecto creado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $esteProyecto = $this->project->with('users')->find($id);

        return view('views_project.detalle_proyecto', compact('esteProyecto'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {   
        // Las policies siempre se ponen al principio del método
        $this->authorize('update', $project);

        $todosUsers = $this->users->all();

        $esteProyecto = $this->project->findOrFail($project->id);

        return view('views_project.editar_proyecto', compact('esteProyecto','todosUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        // Las policies siempre se ponen al principio del método
        $this->authorize('update', $project);


        $esteProyecto = $this->project->find($project);

        // valido los datos
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|',
            'due_date' => 'required|date|after:today',
            'status' => 'required|string'
        ]);

        // 2. Actualizamos el registro en la base de datos
        $esteProyecto->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'status' => $validatedData['status']
        ]);

        // 3. Redirigimos a la vista de detalle o listado
        return redirect()->route('dashboard')->with('success', 'Proyecto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        $this->authorize('delete', $project);

        /*delete() en un modelo Eloquent no acepta argumentos: borra ese mismo modelo. */
        // Se busca
        $esteProyecto = $this->project->findOrFail($project->id);

        // Se elimina
       $esteProyecto->delete();

        return redirect()->route('dashboard')->with('success', 'Proyecto eliminado correctamente.');
    }

}
