<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller{
    public Project $project;

     public function __construct() {
        $this->project = new Project();
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

    // En due_date valido que la fecha de entrega sea mayor que la fecha actual

      $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|',
        'due_date' => 'required|date|after_today',
        'status' => 'required|string'
    ]);

        $validados =  [
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'due_date' => $validatedData['due_date'],
        'status' => $validatedData['status']
    ];
        
        $project = Project::create($validados);

        // Redirijo a la lista de todos los proyectos con un mensaje
        return redirect()->route('views_project.index_project')->with('success', 'Proyecto creado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    $esteProyecto = $this->project->find($id);

    return view('views_project.detalle_proyecto',compact('esteProyecto'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $esteProyecto = $this->project->find($id);

        return view('views_project.editar_proyecto',compact('esteProyecto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    $esteProyecto = $this->project->find($id)->delete();

    // valido los datos
      $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|',
        'due_date' => 'required|date|after_today',
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
    return redirect()->route('views_user.detalle_proyecto', $esteProyecto)->with('success', 'Proyecto actualizado correctamente.');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    $esteProyecto = $this->project->find($id)->delete();

    return redirect()->route('views_user.index_project')->with('success', 'Proyecto eliminado correctamente.');
    }
}
