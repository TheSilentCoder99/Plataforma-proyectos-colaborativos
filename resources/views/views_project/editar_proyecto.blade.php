<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="{{ asset('css/editar_proyecto.css') }}">
</head>

<body>

    <div class="form-container">
        <h1>Editar Proyecto</h1>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Errores de validación -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <fieldset>
        <!-- Formulario de edición -->
        <form action="{{ route('projects.update', $project->id) }}" method="POST" class="project-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required
                    maxlength="255" placeholder="Ingresa el título del proyecto">
            </div>

            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea id="description" name="description" rows="5" required
                    placeholder="Describe el proyecto">{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="due_date">Fecha de Entrega:</label>
                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $project->due_date) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="status">Estado:</label>
                <select id="status" name="status" required>
                    <option value="pendiente" {{ old('status', $project->status) == 'pendiente' ? 'selected' : '' }}>
                        Pendiente</option>
                    <option value="en progreso" {{ old('status', $project->status) == 'en progreso' ? 'selected' : '' }}>En Progreso</option>
                    <option value="completado" {{ old('status', $project->status) == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelado" {{ old('status', $project->status) == 'cancelado' ? 'selected' : '' }}>
                        Cancelado</option>
                </select>
            </div>

            <!-- Para editar los colaboradores, puedo listarlos, asignarles un botón de borrado para quitarlos del proyecto -->
            <!-- y en un select listo todos los usuarios y, al pulsarlos, los agrego al usuario mediante attach -->

            <!-- Muestro los colaboradores actuales -->
            <div>
                <label>Colaboradores:</label>
                <ul class="detail-value">
                    <!-- $esteProyecto->users vs $esteProyecto->users(): sin paréntesis obtienes los datos (la colección); con paréntesis obtienes el constructor de consultas de la relación, útil para encadenar ->where(...) o ->attach(...). Es una confusión muy común. -->

                    @forelse ($project->users as $usuario)
                        <li>
                            {{ $usuario->name }}
                            <small>({{ $usuario->pivot->role }}, {{ $usuario->pivot->contribution_hours }} hrs)</small>
                        </li>
                    @empty
                        <li>Este proyecto aún no tiene colaboradores.</li>
                    @endforelse
                </ul>
            </div>
            
            <a href="{{ route('team.showteam',$project->id) }}" class="actions-container" target="_blank">Editar equipo...</a>

            <div class="actions-container">
                    <button type="submit" class="btn-submit">Guardar Cambios</button>
                </div>
        </form>

        <div class="back-link">
            <a href="{{ route('dashboard') }}">Volver al listado</a>
        </div>
    </div>

</body>

</html>