<!-- resources/views/partials/marcas_modelos.blade.php -->

<div class="container">
    <h1>Gestión de Marcas y Modelos</h1>
    
    <!-- Crear Marca -->
    <h2>Crear Marca</h2>
    <form id="crearMarcaForm" method="POST" action="{{ route('marcas.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nombreMarca" class="form-label">Nombre de la Marca</label>
            <input type="text" class="form-control" id="nombreMarca" name="nombreMarca" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Marca</button>
    </form>

    <hr>

    <!-- Crear Modelo -->
    <h2>Crear Modelo</h2>
    <form id="crearModeloForm" method="POST" action="{{ route('modelos.store') }}">
        @csrf
        <div class="mb-3">
            <label for="buscarMarca" class="form-label">Buscar Marca</label>
            <input type="text" class="form-control" id="buscarMarca" placeholder="Buscar por nombre de la marca">
            <input type="hidden" id="marcaId" name="marcaId">
            <div id="marcaSuggestions" class="list-group"></div>
        </div>
        <div class="mb-3">
            <label for="nombreModelo" class="form-label">Nombre del Modelo</label>
            <input type="text" class="form-control" id="nombreModelo" name="nombreModelo" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Modelo</button>
    </form>

    <hr>

    <!-- Lista de Marcas y Modelos -->
    <h2>Lista de Marcas y Modelos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="marcasModelosTbody">
            @foreach($marcas as $marca)
                @foreach($marca->modelos as $modelo)
                    <tr>
                        <td>{{ $marca->nombre }}</td>
                        <td>{{ $modelo->nombre }}</td>
                        <td>
                            <a href="#" onclick="loadContent('{{ route('modelos.edit', $modelo->id) }}')" class="btn btn-warning"><i class="fa-solid fa-pencil"></i> Editar</a>
                            <form action="{{ route('modelos.destroy', $modelo->id) }}" method="POST" style="display:inline;" onsubmit="return deleteModelo(event, this);">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{ asset('js/marcas_modelos.js') }}"></script>
