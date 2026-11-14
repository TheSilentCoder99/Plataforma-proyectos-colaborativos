<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto</title>
    <!-- Enlazamos el mismo archivo CSS externo -->
    <link rel="stylesheet" href="{{ asset('css/detalle_proyecto.css') }}">
</head>
<body>

    <div class="form-container">
        <h1>Detalles del Proyecto</h1>

        <!-- Contenedor con la información del proyecto -->
        <div class="project-details">
            
            <div class="detail-group">
                <label>Título:</label>
                <p class="detail-value">{{ $esteProyecto-> title }}</p>
            </div>

            <div class="detail-group">
                <label>Descripción:</label>
                <div class="detail-box description-box">
                    {{ $esteProyecto->description }}
                </div>
            </div>

            <div class="detail-group">
                <label>Fecha de Entrega:</label>
                <p class="detail-value">{{ $esteProyecto->due_date }}</p>
            </div>

            <div class="detail-group">
                <label>Estado:</label>
                <p class="detail-value">
                    <span class="status-badge status">
                        {{ $esteProyecto->status }}
                    </span>
                </p>
            </div>

             <div class="detail-group" title="Pulsa el nombre de un colaborador para ver su ficha">
    <label>Colaboradores:</label>
    <ul class="detail-value">

        <!-- $esteProyecto->users vs $esteProyecto->users(): sin paréntesis obtienes los datos (la colección); con paréntesis obtienes el constructor de consultas de la relación, útil para encadenar ->where(...) o ->attach(...). Es una confusión muy común. -->

        @forelse ($esteProyecto->users as $usuario)
            <li>
                <a href="{{ route('users.show', $usuario) }}" target="blank" id="enlace_user">{{ $usuario->name }}</a>

                <small>({{ $usuario->pivot->role }}, {{ $usuario->pivot->contribution_hours }} hrs)</small>
            </li>
        @empty
            <li>Este proyecto aún no tiene colaboradores.</li>
        @endforelse
    </ul>
</div>

        </div>

        <!-- Botones de acción -->
         @can('update',$esteProyecto)
        <div class="actions-container">
            <a href="{{ route('projects.edit', $esteProyecto->id) }}" class="btn-submit" style="text-align: center; text-decoration: none; display: inline-block;">Editar Proyecto</a>
        </div>
        @endcan


        <div class="back-link">
            <a href="{{ route('dashboard') }}">Volver al listado</a>
        </div>
    </div>

</body>
</html>