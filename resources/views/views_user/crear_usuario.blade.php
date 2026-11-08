<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Usuario</title>
    <!-- Enlazamos el archivo CSS independiente -->
    <link rel="stylesheet" href="{{ asset('css/crear_usuario.css') }}">
</head>
<body>

    <div class="form-container">
        <h1>Registrar Nuevo Usuario</h1>

        <!-- Si la validación del controlador falla, mostramos los errores aquí -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- Campo Nombre -->
            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Campo Email -->
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <!-- Campo Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña (mínimo 8 caracteres)</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn-submit">Crear Usuario</button>
        </form>
        
        <div class="back-link">
            <a href="{{ route('users.index') }}">Volver al listado de usuarios</a>
        </div>
    </div>

</body>
</html>