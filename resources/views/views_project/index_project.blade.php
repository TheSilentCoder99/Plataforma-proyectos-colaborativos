<x-app-layout>
    <x-slot name="header">
        <div class="header-bar">
            <h2 class="header-title">
                {{ __('Lista de Proyectos') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="btn-crear">
                Crear Proyecto
            </a>
        </div>
    </x-slot>

    <!-- Enlace al CSS externo -->
    <link rel="stylesheet" href="{{ asset('css/index_project.css') }}">

    <div class="lista-proyectos">
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
                                    <td class="cell-titulo">{{ $project->title }}</td>
                                    <td>{{ Str::limit($project->description, 50) }}</td>
                                    <td class="cell-fecha">{{ $project->due_date }}</td>
                                    <td>
                                        <span class="status-badge status-{{ str_replace(' ', '-', $project->status) }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td class="cell-acciones">
                                        <a href="{{ route('projects.show', $project->id) }}" class="link-accion link-ver">Ver</a>

                                        <a href="{{ route('projects.edit', $project->id) }}" class="link-accion link-editar">Editar</a>

                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="form-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="link-accion link-borrar">Borrar</button>
                                        </form>
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
    </div>
</x-app-layout>