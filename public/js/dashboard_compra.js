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
function attachHandlersCompra() {
    console.log("attachHandlersCompra");
    const numeroFactura = document.getElementById("num_factura");
    const proveedor = document.getElementById("proveedor");
    const montoFinal = document.getElementById("monto_final");
    const fecha = document.getElementById("fecha");
    
    //numero de factura
    document.getElementById('num_factura').addEventListener('input', function (e) {
        var value = e.target.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
        var formattedValue = '';
        
        if (value.length > 0) {
            formattedValue += value.substring(0, 3);
        }
        if (value.length > 3) {
            formattedValue += '-' + value.substring(3, 6);
        }
        if (value.length > 6) {
            formattedValue += '-' + value.substring(6, 13);
        }

        e.target.value = formattedValue;
    });

    document.getElementById("id_marca").addEventListener("change", function () {
        console.log("Marca seleccionada:", this.value);
        const marcaId = this.value;
        cargarModelos(marcaId);
    });
    cargarModelos(1);

    function cargarModelos(marcaId) {
        const modelosDropdown = document.getElementById("id_modelo");
        modelosDropdown.innerHTML = ""; // Limpiar el dropdown de modelos
        modelosDropdown.disabled = true;
        console.log("Cargando modelos para la marca con ID:", marcaId);
        fetch(`/vehiculo/modelos/${marcaId}`)
            .then((response) => response.json())
            .then((data) => {
                console.log("Modelos cargados:", data);
                data.forEach((modelo) => {
                    const option = document.createElement("option");
                    option.value = modelo.id;
                    option.text = modelo.modelo_vehiculo;
                    modelosDropdown.appendChild(option);
                    console.log("Modelo agregado:", modelo.modelo_vehiculo);
                });
                modelosDropdown.disabled = false;
            })
            .catch((error) => console.warn("Error al cargar los modelos:", error));
    }

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
                document.getElementById("telefono_proveedor").value = data.telefono;
                document.getElementById("direccion_proveedor").value = data.direccion;
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire("Proveedor no encontrado", "", "error");
            });
    });

    // Agregar vehículo a la tabla
    document.getElementById("agregarVehiculo").addEventListener("click", async function () {
        const marca = document.getElementById("id_marca").options[document.getElementById("id_marca").selectedIndex].text;
        const id_marca = document.getElementById("id_marca").value;
        const modelo = document.getElementById("id_modelo").options[document.getElementById("id_modelo").selectedIndex].text;
        const id_modelo = document.getElementById("id_modelo").value;
        const precio = parseFloat(document.getElementById("precio_compra").value);
        const estado = document.getElementById("estado").value;
        const año = document.getElementById("año_modelo").value;
        const precio_venta = parseFloat(document.getElementById("precio_venta").value);
        const kilometraje = parseFloat(document.getElementById("kilometraje").value);
        const tipo = document.getElementById("tipo_vehiculo").value;
        const numero_chasis = document.getElementById("numero_chasis").value;
        const numero_motor = document.getElementById("numero_motor").value;
        const placa = document.getElementById("placa").value;
        const descripcion = document.getElementById("descripcion").value;

        // Subir imagen y obtener la URL
        const fotoUrl = await uploadImage();

        if (!fotoUrl) {
            Swal.fire("Error al subir la imagen", "", "error");
            return;
        }

        const total = precio;

        const tableBody = document.getElementById("detalleVehiculos").querySelector("tbody");
        const row = tableBody.insertRow();
        const imageElement = "<img src='" + fotoUrl + "' width='100' height='100'>";
        row.innerHTML = `
            <td value=${id_marca}>${marca}</td>
            <td value=${id_modelo}>${modelo}</td>
            <td>${precio.toFixed(2)}</td>
            <td>${estado}</td>
            <td>${año}</td>
            <td>${precio_venta.toFixed(2)}</td>
            <td>${kilometraje}</td>
            <td>${tipo}</td>
            <td>${numero_chasis}</td>
            <td>${numero_motor}</td>
            <td>${placa}</td>
            <td>${descripcion}</td>
            <td>${imageElement}</td>
            <td>${total.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm eliminarVehiculo">Eliminar</button></td>
        `;

        updateTotal();

        row.querySelector(".eliminarVehiculo").addEventListener("click", function () {
            row.remove();
            updateTotal();
        });

        // Clear inputs
        document.getElementById("id_marca").value = "";
        document.getElementById("id_modelo").value = "";
        document.getElementById("precio_compra").value = "";
        document.getElementById("año_modelo").value = "";
        document.getElementById("precio_venta").value = "";
        document.getElementById("kilometraje").value = "";
        document.getElementById("tipo_vehiculo").value = "";
        document.getElementById("numero_chasis").value = "";
        document.getElementById("numero_motor").value = "";
        document.getElementById("placa").value = "";
        document.getElementById("descripcion").value = "";
        document.getElementById("imagen").value = "";
        document.getElementById("foto_url").value = fotoUrl;
    });

    // Calcular total
    function updateTotal() {
        let total = 0;
        document.querySelectorAll("#detalleVehiculos tbody tr").forEach((row) => {
            const totalRow = parseFloat(row.cells[13].textContent);
            total += totalRow;
        });
        document.getElementById("monto_final").value = total.toFixed(2);
    }

    // Función para subir imagen
    async function uploadImage() {
        const input = document.getElementById("imagen");
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('imagen', input.files[0]);

            try {
                const response = await fetch('/upload-image', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData
                });
                const data = await response.json();
                if (response.ok) {
                    return `/images/${data.image}`; // URL de la imagen subida
                } else {
                    console.error('Error al subir la imagen:', data);
                    return null;
                }
            } catch (error) {
                console.error('Error en la solicitud de subida de imagen:', error);
                return null;
            }
        } else {
            return null;
        }
    }

    // Manejar submit del formulario
    document.getElementById("detalleVehiculoForm").addEventListener("submit", async function (event) {
        event.preventDefault();
        const compradata = [];
        const formData = new FormData(document.getElementById("compraForm"));
        const vehiculos = [];

        document.querySelectorAll("#detalleVehiculos tbody tr").forEach((row) => {
            const img = row.cells[12].querySelector("img");
            const imgSrc = img.getAttribute("src");
            vehiculos.push({
                id_marca: row.cells[0].getAttribute("value"),
                id_modelo: row.cells[1].getAttribute("value"),
                precio_compra: parseFloat(row.cells[2].textContent),
                estado: row.cells[3].textContent,
                año_modelo: parseInt(row.cells[4].textContent),
                precio_venta: parseFloat(row.cells[5].textContent),
                kilometraje: parseFloat(row.cells[6].textContent),
                tipo: row.cells[7].textContent,
                numero_chasis: row.cells[8].textContent,
                numero_motor: row.cells[9].textContent,
                placa: row.cells[10].textContent,
                descripcion: row.cells[11].textContent,
                foto_url: imgSrc,
            });
        });

        formData.append("vehiculos", JSON.stringify(vehiculos));

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
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
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
                    Swal.fire("Compra registrada exitosamente", "", "success");
                    document.getElementById("compraForm").reset();
                    document.querySelector("#detalleVehiculos tbody").innerHTML = "";
                    document.getElementById("monto_final").value = "";
                } else {
                    Swal.fire("Numero de Factura Duplicado", data.error, "error");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire("Error al registrar la compra", "", "error");
            });
    });

    // Manejar cancelación
    document.getElementById("cancelarCompra").addEventListener("click", function () {
        document.getElementById("compraForm").reset();
        document.querySelector("#detalleVehiculos tbody").innerHTML = "";
        document.getElementById("monto_final").value = "";
    });

    // Subir imagen del dispositivo
    document.getElementById('imagen').addEventListener('change', function(event) {
        var input = event.target;
        var previewContainer = document.getElementById('imagePreviewContainer');
        var preview = document.getElementById('imagePreview');
        var removeButton = document.getElementById('removeImage');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);

            removeButton.addEventListener('click', function() {
                input.value = '';
                preview.src = '#';
                previewContainer.style.display = 'none';
            });
        }
    });
}

