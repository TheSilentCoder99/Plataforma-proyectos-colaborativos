<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// Revisar Feature Tests (Pruebas de característica).

// Creo que este controlador no tiene sentido para usuarios normales ya que Breeze trae todo un mega CRUD con el que los usuarios se pueden autogestionar. Esto serviría para un usuario con rol de administrador, pero eso no está en esta BD. Tampoco tiene sentido aplicarle policies si es un administrador. Revisar después. 

class UserController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Eager Loading (carga previa)
        // Pedir una columna completa es como comprar una caja con 100 manzanas de golpe. El problema N+1 es ir a la tienda 100 veces a comprar una manzana por viaje.
        // Usa ::with() al necesitar datos de otras tablas vinculadas

        /*Básicamente, con ::with('loquesea')->get(); lo que consigo es que ANTES de que toda la información llegue a mi RAM, SQL haga dos consultas super optimizadas para traerme tanto la tabla de todos los objetos junto con la propiedad de la tabla pivote que le estoy pidiendo, evitando el N+1 de tener que ir a buscar, en este caso, el proyecto de cada usuario que se esté recorriendo en el for-each  */

        $usuarios = $this->user::with(['projects', 'ownedProjects'])->get();
        
        // Retornamos la vista pasándole la colección de usuarios
        return view('views_user.index_usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     * Su único objetivo es mostrar la vista HTML con el formulario vacío para que el usuario pueda rellenarlo. No toca la base de datos para nada.
     */
    public function create()
    {
        $this->authorize('update');
        return view('views_user.crear_usuario');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // revisar Illuminate\Validation\Rules\Password más adelante
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validados = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ];
        // crea el usuario directamente sin hashear su contraseña porque eso ya se hace directamente en el modelo usuario cada vez que se cree un nuevo usuario y se le asigne una contraseña. Se hace en la función casts
        $user = User::create($validados);

        // Redirijo a la RUTA de todos los usuarios con un mensaje
        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     * Muestra toda la información de un usuario específico mediante su id
     */
    public function show(User $user)
    {

        // Mediante el Route Model Binding, laravel "sabe" que estoy buscando un usuario, entonces hace automáticamente todo lo que está comentado aquí abajo pero de forma oculta:
        /*$UsuarioExiste = User::findOrFail($id); 
        ['user' => $UsuarioExiste]
        Para que esto funcione, ponle a parámetro de la ruta el nombre del objeto a buscar en minuscula y singular y nombra el párametro de esta función de la misma forma.
        */
        return view('views_user.detalle_usuario', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('views_user.formulario_actualizar_usuario', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validamos los datos nuevos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)]
        ]);

        // 2. Actualizamos el registro en la base de datos
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // 3. Redirigimos a la vista de detalle o listado
        return redirect()->route('views_user.detalle_usuario', $user)->with('success', 'Usuario actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');

    }
}
