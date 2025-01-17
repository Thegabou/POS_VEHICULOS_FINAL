<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Venta Vehiculos, Sistema de Facturacion">
    @if($error)
    <title>Error - {{ $error }}</title>
    @else
    <title>Comprando vehículo - {{ $vehiculo->marca->marca_vehiculo }} {{ $vehiculo->modelo->modelo_vehiculo }}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="{{ asset('imagenes/logo_barra.png') }}">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@700&family=Montserrat:wght@300&family=Rubik+Broken+Fax&family=Silkscreen&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
    <link rel="shortcut icon" href="{{ asset('imagenes/logo_barra.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            padding-top: 70px; /* espacio para el header fijo */
        }
        .container {
            margin-top: 20px;
        }
        .form-section, .details-section {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .form-section {
            background: #f9f9f9;
        }
        .details-section {
            background: #fff;
        }
        .form-section:hover, .details-section:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
            transform: translateY(-3px);
        }
        .img-fluid {
            border-radius: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%;
            height: auto;
            max-height: 150px;
            transition: transform 0.3s ease;
        }
        .img-fluid:hover {
            transform: scale(1.1); /* Efecto de zoom */
        }
        .price-breakdown p {
            margin: 0;
        }
        .price-breakdown p:not(:last-child) {
            margin-bottom: 5px;
        }
        .header {
            background-color: white;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .nombre_empresa {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
        }
        .nombre_empresa img {
            width: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }
        .nombre_empresa h1 {
            display: inline;
            vertical-align: middle;
        }
        .hamburger {
            display: none;
        }
        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }
            .pos_vehiculos {
                display: none;
            }
        }
        .vehicle-details {
            text-align: center;
        }
        .vehicle-details h2 {
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .vehicle-details p {
            margin: 5px 0;
        }
        .vehicle-description {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        /* Estilos para la tarjeta de crédito */
        .credit-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 15px;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .credit-card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        .credit-card .logo {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2em;
        }
        .credit-card .card-number, .credit-card .card-holder, .credit-card .expiry-date {
            font-size: 1.2em;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        .credit-card .card-holder {
            text-transform: uppercase;
        }
        .card-wrapper {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header class="header" id="Header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="nombre_empresa">
                <img src="{{ asset('imagenes/logo_marmota.png') }}" alt="Logo Marmota">
                <h1>GroundhogDriver</h1>
            </a>
            <div class="pos_vehiculos">
                <a href="https://www.facebook.com/people/Gabo-Castro/pfbid0311BethBjm2ErBtADaJ8ZRwoKNReJD4xutZEVNruyVehBj7GZn9KqUoXJuQYtDQibl/?mibextid=ZbWKwL"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/gabo_the_shit0?igsh=Z3Z3NTdiM2g4cm42"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://twitter.com/ElkksGabo"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.tiktok.com/@monsterdexx?_t=8jMnQ1Q6MI2&_r=1"><i class="fa-brands fa-tiktok"></i></a>
                <a href="{{ route('login') }}" target="_blank"><i class="fa-solid fa-user"></i></a>
            </div>
            <button class="hamburger">&#9776;</button>
            <div class="menu-overlay"></div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-6 form-section animate__animated animate__fadeInLeft">
                <h1>Detalles de Compra</h1>
                @if($error)
                    <p class="text-danger">{{ $error }}</p>
                @else
                    <form id="purchaseForm">
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required>
                        </div>
                        <div class="form-group">
                            <label for="fullName">Nombre</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Apellido</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <input type="hidden" id="id_cliente" name="id_cliente">

                        <h3>Formas de pago</h3>
                        <div class="payment-method">
                            <label>
                                <input type="radio" name="paymentMethod" value="card" checked> Tarjeta
                            </label>
                            <div class="credit-card">
                                <div class="card-wrapper"></div>
                                <div class="form-group">
                                    <label for="cardNumber">Número de tarjeta</label>
                                    <input type="text" class="form-control card-number" id="cardNumber" name="number" required>
                                </div>
                                <div class="form-group">
                                    <label for="fullName">Nombre del titular</label>
                                    <input type="text" class="form-control card-holder" id="fullName" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="expiryDate">Caducidad</label>
                                    <input type="text" class="form-control expiry-date" id="expiryDate" name="expiry" placeholder="MM/AA" required>
                                </div>
                                <div class="form-group">
                                    <label for="cvc">CVC</label>
                                    <input type="text" class="form-control" id="cvc" name="cvc" required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="vehiculoId" name="vehiculoId" value="{{ $vehiculo->id }}">
                        <input type="hidden" id="subTotal" name="subTotal" value="{{ $vehiculo->precio_venta }}">
                        <input type="hidden" id="total" name="total" value="{{ $vehiculo->precio_venta }}">
                        <button type="submit" class="btn btn-primary btn-block mt-4">Comprar</button>
                        <a href="/" class="btn btn-primary btn-block mt-4">Volver</a>
                    </form>
                @endif
            </div>
            <div class="col-md-6 details-section animate__animated animate__fadeInRight">
                <h1>Detalles del Vehículo</h1>
                @if(!$error)
                    <img src="{{ $vehiculo->foto_url }}" alt="Foto del vehículo" class="img-fluid">
                    <div class="vehicle-details">
                        <h2>{{ $vehiculo->marca->marca_vehiculo }} {{ $vehiculo->modelo->modelo_vehiculo }}</h2>
                        <p>{{ $vehiculo->tipo_vehiculo }}</p>
                        <p>{{ $vehiculo->año_modelo }}</p>
                        <p>{{ $vehiculo->kilometraje }} Km</p>
                        <p><strong>Placa:</strong> {{ $vehiculo->placa }}</p>
                    </div>
                    <div class="price-breakdown text-center">
                        <p><strong>Precio del coche:</strong> ${{ $vehiculo->precio_venta }}</p>
                        <p><strong>Estado:</strong> {{ $vehiculo->estado }}</p>
                    </div>
                    <div class="vehicle-description">
                        <h3>Descripción</h3>
                        <p>{{ $vehiculo->descripcion }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <footer class="text-center text-lg-start text-white" style="background: #FF4E50; background: -webkit-linear-gradient(to left, #ffb34f, #FF4E50); background: linear-gradient(to left, hsla(34, 100%, 65%, 0.651), hsla(359, 100%, 65%, 0.644))">
        <div class="container p-4 pb-0">
            <section class="">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Legal</h6>
                        <p>&copy; 2024 ElectroWorld. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Contacto</h6>
                        <p><a href="mailto:alexandercp998@gmail.com" class="text-white">alexandercp998@gmail.com</a></p>
                        <p><a href="mailto:gabocastro2003@gmail.com" class="text-white">gabocastro2003@gmail.com</a></p>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Teléfonos</h6>
                        <p>0987665505</p>
                        <p>0984663066</p>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Dirección</h6>
                        <p>Carapungo y Pje.Monterrey</p>
                    </div>
                    <div class="col-2 mx-auto mt-2">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Redes Sociales</h6>
                        <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="https://www.facebook.com/people/Gabo-Castro/pfbid0311BethBjm2ErBtADaJ8ZRwoKNReJD4xutZEVNruyVehBj7GZn9KqUoXJuQYtDQibl/?mibextid=ZbWKwL" role="button"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-primary btn-floating m-1" style="background-color: black" href="https://twitter.com/ElkksGabo" role="button"><i class="fab fa-x-twitter"></i></a>
                        <a class="btn btn-primary btn-floating m-1" style="background: #f09433; background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);" href="https://www.instagram.com/gabo_the_shit0?igsh=Z3Z3NTdiM2g4cm42" role="button"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-primary btn-floating m-1" style="background-color: black" href="https://www.tiktok.com/@monsterdexx?_t=8jMnQ1Q6MI2&_r=1" role="button"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </section>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.0.0/jquery.creditCardValidator.js" integrity="sha512-lPypXxa0UnlXWUN7ZF1JI1KpAPijnHZe68gte2EYZ2Z8kWWh/xXw+eRFMhOSgugTOmyHGqKuBjhJoU+3DXWBeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/credit-card-validator@1.0.8/credit-card-validator.min.js"></script>
    <script src="{{ asset('js/compra-vehiculo.js') }}"></script>
</body>
</html>
