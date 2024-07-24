document.addEventListener('DOMContentLoaded', function () {
    const purchaseForm = document.getElementById('purchaseForm');
    const cedulaInput = document.getElementById('cedula');
    const fullNameInput = document.getElementById('fullName');
    const lastNameInput = document.getElementById('lastName');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');

    cedulaInput.addEventListener('blur', function () {
        buscarCliente();
    });

    function buscarCliente() {
        const cedula = cedulaInput.value;
        if (cedula.length > 0) {
            deshabilitarCampos(true);
            const url = "/vendedor/buscar-cliente/" + cedula;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Cliente no encontrado');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('id_cliente').value = data.id;
                    fullNameInput.value = data.nombre || '';
                    lastNameInput.value = data.apellido || '';
                    emailInput.value = data.correo || '';
                    phoneInput.value = data.numero_telefono || '';

                    deshabilitarCampos(true);
                })
                .catch(error => {
                    console.error('Error al buscar el cliente:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Cliente no encontrado',
                        text: 'No se encontró ningún cliente con esa cédula',
                    });
                    limpiarCampos();
                    deshabilitarCampos(false);
                });
        } else {
            limpiarCampos();
            deshabilitarCampos(false);
        }
    }

    function deshabilitarCampos(deshabilitar) {
        fullNameInput.disabled = deshabilitar;
        lastNameInput.disabled = deshabilitar;
        emailInput.disabled = deshabilitar;
        phoneInput.disabled = deshabilitar;
    }

    function limpiarCampos() {
        fullNameInput.value = '';
        lastNameInput.value = '';
        emailInput.value = '';
        phoneInput.value = '';
    }

    if (purchaseForm) {
        purchaseForm.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Procesando compra',
                text: 'Por favor espera mientras procesamos tu compra.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let numeroTarjeta = document.getElementById('cardNumber').value;
            let fechaExpiracion = document.getElementById('expiryDate').value;
            let codigoSeguridad = document.getElementById('cvc').value;

            let datosPago = {
                ultaj4: numeroTarjeta.slice(-4),
                fecha_expiracion: fechaExpiracion,
                codigo_seguridad: codigoSeguridad,
            };

            let formData = {
                nombre: fullNameInput.value,
                apellido: lastNameInput.value,
                correo: emailInput.value,
                telefono: phoneInput.value,
                cedula: cedulaInput.value,
                fecha: new Date().toISOString(),
                tipo_pago: 'Tarjeta de Crédito',
                datos_pago: datosPago,
                vehiculo: {
                    id: document.getElementById('vehiculoId').value
                },
                sub_total: document.getElementById('subTotal').value,
                total: document.getElementById('total').value
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/compra-vehiculo/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Compra realizada con éxito!',
                        text: 'Puedes descargar tu factura ahora.',
                        icon: 'success',
                        confirmButtonText: 'Descargar PDF',
                        willClose: () => {
                            window.location.href = `/facturas/factura_${data.factura.id}.pdf`;
                            setTimeout(() => {
                                window.location.href = '/';
                            }, 2000);
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.error,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        });
    } else {
        console.error('El formulario de compra no se encontró.');
    }
});
