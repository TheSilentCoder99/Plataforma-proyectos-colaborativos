<x-app-layout>
    <x-slot name="header">

        <div class="header-bar" id="arriba">
        
            <a href="{{ route('projects.create') }}" class="btn-crear">
                Crear Proyecto
            </a>
             <a href="{{ route('users.index') }}" class="btn-crear">
                Ver usuarios
            </a>
        </div>
    </x-slot>

   <head>
     <!-- Enlace al CSS y JS externo -->
    <link rel="stylesheet" href="{{ asset('css/index_project.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
   </head>

    <!-- formulario de búsqueda de un proyecto concreto
     La petición GET se hace en esta misma ventana, por eso redirige a esta misma vista. -->
    <form action="{{ route('dashboard') }}" method="GET" class="search-form">
    
    <input type="search" name="q" placeholder="Buscar proyectos..." class="search-input">
    <button type="submit" class="search-btn">Buscar</button>

    <!-- Si se ha buscado algo, se despliegue un enlace para volver a ver todos los proyectos -->
    @if (request('q'))
        <a href="{{ route('dashboard') }}" class="search-clear">Ver todos</a>
    @endif
</form>

    <div class="lista-proyectos" title="haz click en el nombre de un proyecto para ver sus detalles">
        <div class="lista-proyectos__container">

            @if (session('success'))
                <div class="alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">

                    <table class="tabla-proyectos">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Fecha Límite</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($proyectos as $project)
                                <tr>
                                    <td class="cell-titulo"><a href="{{ route('projects.show',$project) }}" target="_blank">{{ $project->title }}</a></td>
                                    <td>{{ Str::limit($project->description, 50) }}</td>
                                    <td class="cell-fecha">{{ $project->due_date }}</td>
                                    <td>
                                        <span class="status-badge status-{{ str_replace(' ', '-', $project->status) }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td class="cell-acciones">
                                        <a href="{{ route('projects.show', $project->id) }}" class="link-accion link-ver">Ver</a>

                                        <!-- Solo el dueño del proyecto puede actualizarlo o borrarlo -->
                                        @can('update', $project)
                                            <a href="{{ route('projects.edit', $project->id) }}">Editar</a>
                                        @endcan

                                        @can('delete', $project)
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="form-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="link-accion link-borrar borrar_proyecto">Borrar</button>
                                        </form>
                                        @endcan

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-row">
                                        No hay proyectos registrados todavía.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <a href="#arriba" class="btn-ir-arriba">Ir arriba</a>

    </div>
</x-app-layout>