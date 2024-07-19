@foreach($vehiculos as $vehiculo)
    @if($vehiculo->inventario->stock > 0)
        <div class="producto" 
             data-id="{{ $vehiculo->id }}" 
             data-marca="{{ $vehiculo->marca }}" 
             data-modelo="{{ $vehiculo->modelo }}" 
             data-precio-venta="{{ $vehiculo->precio_venta }}" 
             data-foto-url="{{ $vehiculo->foto_url }}" 
             data-stock="{{ $vehiculo->inventario->stock }}">
            <span class="titulo_producto">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</span>
            <img src="{{ $vehiculo->foto_url }}" alt="" class="img-item">
            <span class="precio_txt">Precio:</span>
            <span class="precio_producto">${{ number_format($vehiculo->precio_venta, 2) }}</span>
            <button class="boton_producto" onclick="agregarcarritoclick(event)">Comprar</button>
        </div>
    @else
        <div class="producto">
            <span class="titulo_producto">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</span>
            <img src="{{ $vehiculo->foto_url }}" alt="" class="img-item">
            <span class="precio_txt">Precio:</span>
            <span class="precio_producto">${{ number_format($vehiculo->precio_venta, 2) }}</span>
            <span class="sin_stock">Sin stock</span>
        </div>
    @endif
@endforeach
