var carritoVisible = false;

if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready();
}

function ready() {
    // Funcionalidad de los botones eliminar
    var botonesEliminar = document.getElementsByClassName('btn_eliminar');
    for (var i = 0; i < botonesEliminar.length; i++) {
        var button = botonesEliminar[i];
        button.addEventListener('click', eliminarcarrito);
    }

    // Funcionalidad a los botones quitar-agregar
    var botonessuma = document.getElementsByClassName('sumar-cantidad');
    for (var i = 0; i < botonessuma.length; i++) {
        var button = botonessuma[i];
        button.addEventListener('click', sumarcantidad);
    }

    var botonesresta = document.getElementsByClassName('restar-cantidad');
    for (var i = 0; i < botonesresta.length; i++) {
        var button = botonesresta[i];
        button.addEventListener('click', restarcantidad);
    }

    // Funcionalidad a los botones comprar
    var botonescomprar = document.getElementsByClassName('boton_producto');
    for (var i = 0; i < botonescomprar.length; i++) {
        var button = botonescomprar[i];
        button.addEventListener('click', agregarcarritoclick);
    }

    // Funcionalidad al boton pagar
    document.getElementsByClassName('btn_pagar')[0].addEventListener('click', pagarclicked)
}

// Eliminar productos del carrito
function eliminarcarrito(event) {
    var buttonclick = event.target;
    buttonclick.parentElement.parentElement.remove();

    actualizarcarrito();

    ocultarCarrito();
}

function actualizarcarrito() {
    var carritocontenedor = document.getElementsByClassName('carrito')[0];
    var carritoitem = carritocontenedor.getElementsByClassName('carrito-item');
    var total = 0;

    for (var i = 0; i < carritoitem.length; i++) {
        var item = carritoitem[i];
        var precioproducto = item.getElementsByClassName('carrito-item-precio')[0];
        var precio = parseFloat(precioproducto.innerText.replace('$', '').replace(',', ''));
        var cantidadproducto = item.getElementsByClassName('carrito-item-cantidad')[0];
        var cantidad = cantidadproducto.value;
        total = total + (precio * cantidad);
    }
    total = Math.round(total * 100) / 100;
    document.getElementsByClassName('carrito-precio-total')[0].innerText = '$' + total.toLocaleString("es") + ',00';
}

function ocultarCarrito() {
    var carritoitems = document.getElementsByClassName('carrito-items')[0];
    if (carritoitems.childElementCount == 0) {
        var carrito = document.getElementsByClassName('carrito')[0];
        carrito.style.marginRight = '-100%';
        carrito.style.opacity = '0';
        carritoVisible = false;

        // Se maximiza el contenedor de los elementos
        var items = document.getElementsByClassName('contenedor_productos')[0];
        items.style.width = '100%';
    }
}

function sumarcantidad(event) {
    var buttonclick = event.target;
    var selector = buttonclick.parentElement;
    var cantidadactual = selector.getElementsByClassName('carrito-item-cantidad')[0].value;
    cantidadactual++;
    selector.getElementsByClassName('carrito-item-cantidad')[0].value = cantidadactual;

    actualizarcarrito();
}

function restarcantidad(event) {
    var buttonclick = event.target;
    var selector = buttonclick.parentElement;
    var cantidadactual = selector.getElementsByClassName('carrito-item-cantidad')[0].value;
    cantidadactual--;

    if (cantidadactual >= 1) {
        selector.getElementsByClassName('carrito-item-cantidad')[0].value = cantidadactual;
        actualizarcarrito();
    }
}







