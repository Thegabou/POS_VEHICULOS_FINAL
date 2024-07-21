@foreach($vehiculos as $vehiculo)
        <div class="producto" 
             data-id="{{ $vehiculo->id }}" 
             data-marca="{{ $vehiculo->marca }}" 
             data-modelo="{{ $vehiculo->modelo }}" 
             data-precio-venta="{{ $vehiculo->precio_venta }}" 
             data-foto-url="{{ $vehiculo->foto_url }}" 
             data-estado="{{ $vehiculo->estado }}">
            <span class="titulo_producto">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</span>
            <img src="{{ $vehiculo->foto_url }}" alt="" class="img-item">
            <span class="precio_txt">Precio:</span>
            <span class="precio_producto">${{ number_format($vehiculo->precio_venta, 2) }}</span>
            @if($vehiculo->estado === 'Disponible')
                <button class="boton_producto" onclick="agregarcarritoclick(event)">Comprar</button>
            @else
                <span class="sin_stock">{{ $vehiculo->estado }}</span>
            @endif
        </div>
    @endforeach