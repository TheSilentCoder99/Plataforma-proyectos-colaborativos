<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/index_usuarios.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>

    <!-- Cabecera: logo + búsqueda -->
    <header class="site-header">
        <a href="{{ route('dashboard') }}" class="site-logo">
            <img src="{{ asset('img/logo_proyecto.png') }}"
                 alt="Logo de la web. Bombilla representando la idea de los proyectos">
        </a>
        <form action="{{ route('users.index') }}" method="GET" class="search-form">
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Buscar usuarios..." class="search-input">
            <button type="submit" class="search-btn">Buscar</button>

            @if (request('q'))
                <a href="{{ route('users.index') }}" class="search-clear">Limpiar</a>
            @endif
        </form>

    <div class="form-container" style="max-width: 900px;" id="arriba">
        <!-- Ampliado para que quepa la tabla -->
        <h1>Listado de usuarios ({{count($usuarios)}}):</h1>

        @if (session('success'))
            <div class="alert-success" style="margin-bottom: 20px; color: green;">
                {{ session('success') }}
            </div>
        @endif

        <!-- El método create de una Policy solo recibe el usuario autenticado, no ningún modelo objetivo:
        Con solo el nombre 'create' y sin clase, Laravel no sabe a qué Policy preguntar, porque no hay modelo del que deducirla. Buscaría un Gate llamado create, no lo encontraría y denegaría siempre. Para las acciones sin instancia se pasa la clase:
        Con la clase, Laravel localiza UserPolicy y llama a create($authUser). -->
        @can('create', App\Models\User::class)
            <a href="{{ route('users.create') }}">Crear nuevo usuario</a>
        @endcan

        <a href="{{ route('dashboard') }}">Ver proyectos</a>
        <a href="{{ route('projects.create') }}">Crear proyecto</a>

        <!-- Datos del usuario de cada usuario-->
        <table class="tabla-proyectos" style="width: 100%; border-collapse: collapse;" title="pulsa el nombre de un usuario para acceder a su ficha">
            <thead>
                <tr style="border-bottom: 2px solid #252EB0;">
                    <th style="text-align: left; padding: 10px;">Nombre</th>
                    <th style="text-align: left; padding: 10px;">Email</th>
                    <th style="text-align: left; padding: 10px;">Proyectos Asociados</th>
                    <th style="text-align: right; padding: 10px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $user)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;" class="cell-nombre"><a href="{{ route('users.show',$user) }}" target="_blank" class="ver-usuarios">{{ $user->name }}</a></td>
                        <td style="padding: 10px;">{{ Str::limit($user->email, 50) }}</td>

                        <!-- Mostramos los proyectos de este usuario gracias a la relación -->
                        <td style="padding: 10px;">
                            @if($user->projects->count() > 0)
                                <ul style="margin: 0; padding-left: 15px;">

                                    <!-- Recorro los proyectos de cada usuario y traigo el título y el status -->
                                    @foreach($user->projects as $proyecto)

                                        <li>{{ $proyecto->title }}</li>
                                        <li>{{ $proyecto->status }}</li>
                                        <!-- A través de la tabla pivote accedo también al rol y a las horas de contribución de cada usuario -->
                                        <li>{{ $proyecto->pivot->role }} - {{ $proyecto->pivot->contribution_hours }} hrs</li>
                                    @endforeach
                                </ul>
                            @else
                                <span style="color: #888; font-style: italic;">Sin proyectos</span>
                            @endif
                        </td>

                        <td style="padding: 10px; text-align: right;" class="cell-acciones">
                            <a href="{{ route('users.show', $user->id) }}"
                                style="color: #252EB0; margin-right: 5px;">Ver</a>

                            <!-- Solo se puede editar un usuario si uno mismo es admin -->
                            @can('update', $user)
                                <a href="{{ route('users.edit', $user->id) }}"
                                    style="color: #d97706; margin-right: 5px;">Editar</a>
                            @endcan

                            <!-- Solo se puede borrar un usuario si uno mismo es admin -->
                            @can('delete', $user)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer;"
                                        class="borrar_user">Borrar usuario</button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @empty
                    <tr>
                        <!-- Corregido a 4 porque ahora tenemos 4 columnas en total -->
                        <td colspan="4" style="text-align: center; padding: 20px;" class="empty-row">
                            No hay usuarios registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="#arriba" class="btn-ir-arriba">Ir arriba</a>
</body>

</html>