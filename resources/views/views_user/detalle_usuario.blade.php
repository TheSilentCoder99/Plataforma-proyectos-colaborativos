<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/detalle_usuario.css') }}">
</head>

<body>
    <div class="form-container" style="max-width: 900px;">
        <a href="{{ route('users.index') }}">Ver listado de usuarios</a>

        <h1>{{ $user->name }}</h1>
        <a href="{{ route('users.edit', $user->id) }}" style="color: #d97706; margin-right: 5px;">Editar</a>
        <td style="padding: 10px; text-align: right;" class="cell-acciones">
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">Borrar
                    usuario</button>
            </form>
        </td>

        <div>
            {{ $user->email }}
        </div>

        @if (session('success'))
            <div class="alert-success" style="margin-bottom: 20px; color: green;">
                {{ session('success') }}
            </div>
        @endif

        <table class="tabla-proyectos" style="width: 100%; border-collapse: collapse;">
            <tbody>
                @forelse($user->projects as $proyecto)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;">
                            <ul style="margin: 0; padding-left: 15px;">
                                <li>{{ $proyecto->title }}</li>
                                <li>{{ $proyecto->status }}</li>
                                <li>{{ $proyecto->pivot->role }} - {{ $proyecto->pivot->contribution_hours }} hrs</li>
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;" class="empty-row">
                            Este usuario no tiene proyectos asignados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>