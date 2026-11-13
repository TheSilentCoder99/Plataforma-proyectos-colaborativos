<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo</title>
    <link rel="stylesheet" href="{{ asset('css/gestionar_equipo.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>
    <h1>Gestión del equipo</h1>

    <div title="Pulsa el nombre de un colaborador para ver su ficha">
        <label>Colaboradores Actuales:</label>
        <ul class="detail-value">
            <!-- $ProyectoRecibeUser->users vs $ProyectoRecibeUser->users(): sin paréntesis obtienes los datos (la colección); con paréntesis obtienes el constructor de consultas de la relación, útil para encadenar ->where(...) o ->attach(...). Es una confusión muy común. -->

            @forelse ($ProyectoRecibeUser->users as $usuario)
                <li>
                    <a href="{{ route('users.show', $usuario) }}" target="blank" id="enlace_user"><escape><span class="user-info">
                        {{ $usuario->name }}
                        <small>
                            ({{ $usuario->pivot->role }},
                            {{ $usuario->pivot->contribution_hours }} hrs)
                        </small>
                    </span></escape></a>

                    <form action="{{ route('team.deleteUser', $ProyectoRecibeUser) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $usuario->id }}">
                        <button type="submit" title="Elimina este colaborador." class="boton_cancelar">X</button>
                    </form>
                </li>
            @empty
                <li class="empty-row">Este proyecto aún no tiene colaboradores.</li>
            @endforelse
        </ul>
    </div>

    <label for="colaboradores">Agregar colaboradores:</label>
    <form action="{{ route('team.addUser', $ProyectoRecibeUser) }}" method="POST" class="project-form">
        @csrf
        @method('POST')

        <div class="form-group">
            <select name="id" size="5">
                <!-- Muestro todos para dar la opción de añadirlos al proyecto -->
                @foreach ($todosUsers as $usuarios)
                    <option value="{{ $usuarios->id }}"> {{ $usuarios->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Pero qué pasa si el usuario quiere añadir varios usuarios a la vez y añadirles diferentes roles? Creo un array asociativo que una rol elegido con id de usuario? -->

        <div class="form-group">
            <label for="role">Rol en el Proyecto:</label>
            <select id="role" name="role" required class="form-control">
                <option value="" disabled selected>Selecciona un rol...</option>
                <option value="Desarrollador backend">Desarrollador backend</option>
                <option value="Desarrollador frontend">Desarrollador frontend</option>
                <option value="Scrum Master">Scrum Master</option>
                <option value="Project Manager">Project Manager</option>
                <option value="Diseñador UX/UI">Diseñador UX/UI</option>
                <option value="Desarrollador Full-Stack">Desarrollador Full-Stack</option>
                <option value="Ingeniero QA">Ingeniero QA</option>
                <option value="Ingeniero DevOps">Ingeniero DevOps</option>
                <option value="Product Owner">Product Owner</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contribution_hours">Horas de contribución:</label>
            <input type="number" min="0" id="contribution_hours" name="contribution_hours" required>
        </div>

        

        <div class="actions-container">
            <button type="submit">Agregar colaboradores</button>
        </div>

         <div class="back-link">
            <a href="{{ route('projects.edit', $ProyectoRecibeUser) }}">Volver al proyecto</a>
        </div>

    </form>
</body>

</html>