<div class="container">
    <h1>Editar Cliente</h1>
    <form id="form-edit-cliente" action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $cliente->apellido }}" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $cliente->correo }}" required>
        </div>
        <div class="form-group">
            <label for="numero_telefono">Número de Teléfono:</label>
            <input type="number" class="form-control" id="numero_telefono" name="numero_telefono" value="{{ $cliente->numero_telefono }}" required>
        </div>
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="number" class="form-control" id="cedula" name="cedula" value="{{ $cliente->cedula }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        <button type="button" class="btn btn-secondary" onclick="loadContent('{{ route('clientes.index') }}')">Volver</button>
    </form>
</div>
