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
                <p class="detail-value">{{ $esteProyecto->title }}</p>
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
                    <span class="status-badge status-{{ str_replace(' ', '-', $esteProyecto->status) }}">
                        {{ ucfirst($esteProyecto->status) }}
                    </span>
                </p>
            </div>

        </div>

        <!-- Botones de acción -->
        <div class="actions-container">
            <a href="{{ route('projects.edit', $esteProyecto->id) }}" class="btn-submit" style="text-align: center; text-decoration: none; display: inline-block;">Editar Proyecto</a>
        </div>

        <div class="back-link">
            <a href="{{ route('dashboard') }}">Volver al listado</a>
        </div>
    </div>

</body>
</html>