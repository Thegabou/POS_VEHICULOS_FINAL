<!-- resources/views/partials/index/contenedor_vehiculos.blade.php -->

@foreach($vehiculos as $vehiculo)
<div class="producto">
    <span class="titulo_producto">{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</span>
    <img src="{{ $vehiculo->foto_url }}" alt="" class="img-item">
    <span class="precio_txt">Precio:</span>
    <span class="precio_producto">${{ number_format($vehiculo->precio_venta, 2) }}</span>
    <button class="boton_producto">Comprar</button>
</div>
@endforeach
