// Función para cargar contenido dinámicamente
function loadContent(url) {
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            document.getElementById("main-content").innerHTML = html;
            attachHandlers(); // Attach handlers after loading content
        })
        .catch((error) => console.warn(error));
}




// Attach handlers for the form interactions
function attachHandlers() {
    const numeroFactura = document.getElementById("num_factura");
            const proveedor = document.getElementById("proveedor");
            const montoFinal = document.getElementById("monto_final");
            const fecha = document.getElementById("fecha");
    // Poblar marcas y modelos
    fetch("/marcas")
        .then((response) => response.json())
        .then((data) => {
            const marcasList = document.getElementById("marcasList");
            data.forEach((marca) => {
                const option = document.createElement("option");
                option.value = marca;
                marcasList.appendChild(option);
            });
        });

    fetch("/modelos")
        .then((response) => response.json())
        .then((data) => {
            const modelosList = document.getElementById("modelosList");
            data.forEach((modelo) => {
                const option = document.createElement("option");
                option.value = modelo;
                modelosList.appendChild(option);
            });
        });

        // Autocompletar proveedor
    document.getElementById("ruc").addEventListener("blur", function () {
        const ruc = this.value;
        fetch(`/proveedores/${ruc}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Proveedor no encontrado");
                }
                return response.json();
            })
            .then((data) => {
                document.getElementById("proveedor").value = data.id;
                document.getElementById("nombre_proveedor").value = data.nombre;
                document.getElementById("correo_proveedor").value = data.correo;
                document.getElementById("telefono_proveedor").value =
                    data.telefono;
                document.getElementById("direccion_proveedor").value =
                    data.direccion;
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire("Proveedor no encontrado", "", "error");
            });
    });

    // Agregar vehículo a la tabla
    document
        .getElementById("agregarVehiculo")
        .addEventListener("click", function () {
            const marca = document.getElementById("marca").value;
            const modelo = document.getElementById("modelo").value;
            const precio = parseFloat(
                document.getElementById("precio_compra").value
            );
            const estado = document.getElementById("estado").value;
            const año = document.getElementById("año_modelo").value;
            const precio_venta = parseFloat(
                document.getElementById("precio_venta").value
            );
            const kilometraje = parseFloat(
                document.getElementById("kilometraje").value
            );
            const tipo = document.getElementById("tipo_vehiculo").value;
            const foto = document.getElementById("foto_url").value;
            const total = precio;

            const tableBody = document
                .getElementById("detalleVehiculos")
                .querySelector("tbody");
            const row = tableBody.insertRow();
            const imageElement =
                "<img src='" + foto + "' width='100' height='100'>";
            row.innerHTML = `
        <td>${marca}</td>
        <td>${modelo}</td>
        <td>${precio.toFixed(2)}</td>
        <td>${estado}</td>
        <td>${año}</td>
        <td>${precio_venta.toFixed(2)}</td>
        <td>${kilometraje}</td>
        <td>${tipo}</td>
        <td>${imageElement}</td>
        <td>${total.toFixed(2)}</td>
        <td><button type="button" class="btn btn-danger btn-sm eliminarVehiculo">Eliminar</button></td>
    `;

            updateTotal();

            row.querySelector(".eliminarVehiculo").addEventListener(
                "click",
                function () {
                    row.remove();
                    updateTotal();
                }
            );

            // Clear inputs
            document.getElementById("marca").value = "";
            document.getElementById("modelo").value = "";
            document.getElementById("precio_compra").value = "";
            document.getElementById("año_modelo").value = "";
            document.getElementById("precio_venta").value = "";
            document.getElementById("kilometraje").value = "";
            document.getElementById("tipo_vehiculo").value = "";
            document.getElementById("foto_url").value = "";
        });

    // Calcular total
    function updateTotal() {
        let total = 0;
        document
            .querySelectorAll("#detalleVehiculos tbody tr")
            .forEach((row) => {
                const totalRow = parseFloat(row.cells[9].textContent);
                total += totalRow;
            });
        document.getElementById("monto_final").value = total.toFixed(2);
    }
     
    // Manejar submit del formulario
    document
        .getElementById("detalleVehiculoForm")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            const compradata = [];
            const formData = new FormData(
                document.getElementById("compraForm")
            );
            const vehiculos = [];

            document
                .querySelectorAll("#detalleVehiculos tbody tr")
                .forEach((row) => {
                    //obtener la url de la imagen a partir del elemento img en la celda 8
                    const img = row.cells[8].querySelector("img");
                    const imgSrc = img.getAttribute("src");
                    vehiculos.push({
                        marca: row.cells[0].textContent,
                        modelo: row.cells[1].textContent,
                        precio_compra: parseFloat(row.cells[2].textContent),
                        estado: row.cells[3].textContent,
                        año_modelo: parseInt(row.cells[4].textContent),
                        precio_venta: parseFloat(row.cells[5].textContent),
                        kilometraje: parseFloat(row.cells[6].textContent),
                        tipo: row.cells[7].textContent,
                        foto_url: imgSrc, // assuming this is a constant value for all rows
                    });
                });

            formData.append("vehiculos", JSON.stringify(vehiculos));

            console.log(numeroFactura);
            console.log(proveedor);
            console.log(montoFinal);
            console.log(fecha);

            if (!numeroFactura || !proveedor || !montoFinal || !fecha) {
                console.error("Some elements are missing in the DOM");
                return;
            }

            compradata.push({
                numero_factura: numeroFactura.value,
                id_proveedor: parseInt(proveedor.value),
                monto_final: parseFloat(montoFinal.value),
                fecha: fecha.value,
            });

            formData.append("compra", JSON.stringify(compradata));

            fetch("/dashboard/compras", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        Swal.fire(
                            "Compra registrada exitosamente",
                            "",
                            "success"
                        );
                        document.getElementById("compraForm").reset();
                        document.querySelector(
                            "#detalleVehiculos tbody"
                        ).innerHTML = "";
                        document.getElementById("monto_final").value = "";
                    } else {
                        Swal.fire("Error al registrar la compra", "", "error");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire("Error al registrar la compra", "", "error");
                });
        });

    // Manejar cancelación
    document
        .getElementById("cancelarCompra")
        .addEventListener("click", function () {
            document.getElementById("compraForm").reset();
            document.querySelector("#detalleVehiculos tbody").innerHTML = "";
            document.getElementById("monto_final").value = "";
        });
}

document.addEventListener("DOMContentLoaded", function () {
   
});
