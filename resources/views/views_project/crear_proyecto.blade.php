<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo proyecto</title>
    <!-- Enlazamos el archivo CSS externo -->
    <!-- assets manda a la Laravel a buscar en public -->
    <link rel="stylesheet" href="{{ asset('css/crear_proyecto.css') }}">
</head>

<body>
    <div class="form-container">

        <h1>Crear Nuevo Proyecto</h1>

        <!-- Si hay errores de validación, los mostramos -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- Campo Título -->
            <div class="form-group">
                <label for="title">Título del Proyecto</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <!-- Campo Descripción -->
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <!-- Campo Fecha de Entrega -->
            <div class="form-group">
                <label for="due_date">Fecha de Entrega</label>
                <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
            </div>

            <!-- Campo Status (Select cerrado) -->
            <div class="form-group">
                <label for="status">Estado</label>
                <select id="status" name="status" required>
                    <option value="" disabled selected>Selecciona un estado...</option>
                    <option value="terminado" {{ old('status') == 'terminado' ? 'selected' : '' }}>Terminado</option>
                    <option value="activo" {{ old('status') == 'activo' ? 'selected' : '' }}>En proceso</option>
                    <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="pausado" {{ old('status') == 'pausado' ? 'selected' : '' }}>Pausado</option>
                </select>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn-submit">Guardar Proyecto</button>
        </form>

        <div class="back-link">
            <a href="{{ route('dashboard') }}">Volver al proyecto</a>
        </div>

    </div>

</body>

</html>