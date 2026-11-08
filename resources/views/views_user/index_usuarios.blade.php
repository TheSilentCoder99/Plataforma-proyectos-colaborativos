<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/index_usuarios.css') }}">
</head>
<body>
    <div class="form-container" style="max-width: 900px;"> <!-- Ampliado para que quepa la tabla -->
        <h1>Listado de usuarios</h1>

        @if (session('success'))
            <div class="alert-success" style="margin-bottom: 20px; color: green;">
                {{ session('success') }}
            </div>
        @endif

            <a href="{{ route('users.create') }}">Crear nuevo usuario</a>

        <!-- Datos del usuario de cada usuario-->
        <table class="tabla-proyectos" style="width: 100%; border-collapse: collapse;">
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
                        <td style="padding: 10px;" class="cell-nombre">{{ $user->name }}</td>
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
                            <a href="{{ route('users.show', $user->id) }}" style="color: #252EB0; margin-right: 5px;">Ver</a>
                            <a href="{{ route('users.edit', $user->id) }}" style="color: #d97706; margin-right: 5px;">Editar</a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">Borrar</button>
                            </form>
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
</body>
</html>