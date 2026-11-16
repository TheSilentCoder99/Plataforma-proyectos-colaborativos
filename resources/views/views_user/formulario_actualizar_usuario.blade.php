<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="{{ asset('css/actualizar_usuario.css') }}">
</head>

<body>
    <div class="form-container" style="max-width: 600px;">
        <a href="{{ route('users.index') }}" class="btn-volver">← Volver al listado</a>

        <h1>Editar usuario</h1>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="form-usuario">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nombre</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="@error('name') input-error @enderror"
                    placeholder="Nombre del usuario"
                    required
                    autofocus>
                @error('name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="@error('email') input-error @enderror"
                    placeholder="correo@ejemplo.com"
                    required>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

                    <div class="form-group">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="@error('password') input-error @enderror"
                    required
                    placeholder="minimo 8 caractéres">
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-guardar">Guardar cambios</button>
                <a href="{{ route('users.show', $user) }}" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>