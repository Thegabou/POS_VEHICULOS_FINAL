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

function agregarcarritoclick(event) {
    var button = event.target;
    var item = button.parentElement;
    var id = item.getAttribute('data-id');
    var marca = item.getAttribute('data-marca');
    var modelo = item.getAttribute('data-modelo');
    var precio_venta = item.getAttribute('data-precio-venta');
    var foto_url = item.getAttribute('data-foto-url');
    var stock = item.getAttribute('data-stock');

    agregarCarrito(id, marca, modelo, foto_url, precio_venta, stock);

    // Hacer visible solo si se presiona el botón comprar
    hacerVisiblecarrito();
}

function agregarCarrito(id, marca, modelo, foto_url, precio_venta, stock) {
    var itemscarrito = document.getElementsByClassName('carrito-items')[0];

    if (stock <= 0) {
        alert("El vehículo no está disponible en stock.");
        return;
    }

    // Verificar si el producto ya está en el carrito
    var nombresItemscarrito = itemscarrito.getElementsByClassName('carrito-item');
    for (var g = 0; g < nombresItemscarrito.length; g++) {
        var carritoItem = nombresItemscarrito[g];
        if (carritoItem.getAttribute('data-id') == id) {
            alert("El item ya se encuentra en el carrito");
            return;
        }
    }

    // Crear el nuevo ítem del carrito
    var itemcarritoContenido = `
    <div class="carrito-item" data-id="${id}">
        <img src="${foto_url}" alt="" width="80px">
        <div class="carrito-item-detalles">
            <span class="carrito-item-titulo">${marca} - ${modelo}</span>
            <div class="selector-catidad">
                <i class="fa-solid fa-minus restar-cantidad"></i>
                <input type="text" value="1" class="carrito-item-cantidad" disabled>
                <i class="fa-solid fa-plus sumar-cantidad"></i>
            </div>
            <span class="carrito-item-precio">${precio_venta}</span>
        </div>
        <span class="btn_eliminar">
            <i class="fa-solid fa-trash"></i>
        </span> 
    </div>
    `;
    var item = document.createElement('div');
    item.innerHTML = itemcarritoContenido;
    itemscarrito.appendChild(item);

    // Funcionalidad eliminar el nuevo item
    item.getElementsByClassName('btn_eliminar')[0].addEventListener('click', eliminarcarrito);
    // Funcionalidad quitar-agregar
    var botonsumar = item.getElementsByClassName('sumar-cantidad')[0];
    botonsumar.addEventListener('click', sumarcantidad);

    var botonrestar = item.getElementsByClassName('restar-cantidad')[0];
    botonrestar.addEventListener('click', restarcantidad);

    actualizarcarrito();
}

function pagarclicked() {
    alert("Gracias por su compra :D");

    var carritoitems = document.getElementsByClassName('carrito-items')[0];
    while (carritoitems.hasChildNodes()) {
        carritoitems.removeChild(carritoitems.firstChild);
    }
    actualizarcarrito();
    // Función para ocultar el carrito
    ocultarCarrito();
}

function hacerVisiblecarrito() {
    carritoVisible = true;
    var carrito = document.getElementsByClassName('carrito')[0];
    carrito.style.marginRight = '0';
    carrito.style.opacity = '1';

    var items = document.getElementsByClassName('contenedor_productos')[0];
    items.style.width = '60%';
}
