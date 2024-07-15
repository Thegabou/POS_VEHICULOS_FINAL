<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Venta Vehiculos, Sistema de Facturacion">
    <title>GroundHogDriver</title>
    <link rel="apple-touch-icon" href="{{asset('imagenes/logo_barra.png')}}">
    <link rel="stylesheet" href="{{asset('css/estilo.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Exo+2:wght@700&family=Montserrat:wght@300&family=Rubik+Broken+Fax&family=Silkscreen&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/productos.css')}}">
    <link rel="shortcut icon" href="{{asset('imagenes/logo_barra.png')}}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <header class="header" id="Header">
        <div class="nombre_empresa">
            <h1>GroundhogDriver</h1>
        </div>
        <div class="pos_vehiculos">
            <a
                href="https://www.facebook.com/people/Gabo-Castro/pfbid0311BethBjm2ErBtADaJ8ZRwoKNReJD4xutZEVNruyVehBj7GZn9KqUoXJuQYtDQibl/?mibextid=ZbWKwL"><i
                    class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/gabo_the_shit0?igsh=Z3Z3NTdiM2g4cm42"><i
                    class="fa-brands fa-instagram"></i></a>
            <a href="https://twitter.com/ElkksGabo"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="https://www.tiktok.com/@monsterdexx?_t=8jMnQ1Q6MI2&_r=1"><i class="fa-brands fa-tiktok"></i></a>
            <a href="{{route('login')}}" target="_blank"><i class="fa-solid fa-user"></i></a>
        </div>
        <button class="hamburger">&#9776;</button>
        <div class="menu-overlay"></div>
    </header>
    <section class="encabezado">
        <img src="{{asset('imagenes/logo_marmota.png')}}" alt="" width="160" />
        <h1>
            "GroundhogDriver:<br> Todo lo que hagas sobre ruedas"
        </h1>
    </section>

    <section class="contenedor">
        <div class="contenedor_productos">
            <div class="producto">
                <span class="titulo_producto">Refrigeradora Indurama</span>
                <img src="Images/refrigeradora.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$500</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Microondas LG</span>
                <img src="Images/microondas2.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$250</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Television Samsung 55"</span>
                <img src="Images/television.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$780</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Licuadora Watson plateada</span>
                <img src="Images/licuadora.webp" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$225</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Lavadora Samsung</span>
                <img src="Images/lavadora.webp" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$550</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Sanduchera Indurama</span>
                <img src="Images/sanduchera.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$75.00</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Tostadora Oster</span>
                <img src="Images/tostadora.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$300</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Aspiradora Rumania</span>
                <img src="Images/aspiradora.png" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$120</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Cocina Mabe</span>
                <img src="Images/cocina.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$800</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Batidora ASAP</span>
                <img src="Images/batidora.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$125</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Plancha West</span>
                <img src="Images/plancha.webp" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$80</span>
                <button class="boton_producto">Comprar</button>
            </div>
            <div class="producto">
                <span class="titulo_producto">Extractor de olores Mabe</span>
                <img src="Images/extractor.jpg" alt="" class="img-item">
                <span class="precio_txt">Precio:</span>
                <span class="precio_producto">$400</span>
                <button class="boton_producto">Comprar</button>
            </div>
        </div>

        <div class="carrito">
            <div class="header-carrito">
                <h1>Tu Carrito</h1>
            </div>

            <div class="carrito-items">
            </div>
            <div class="carrito-total">
                <div class="fila">
                    <strong>Total</strong>
                    <span class="carrito-precio-total">
                        $000000
                    </span>
                </div>
                <button class="btn_pagar">Pagar</button>
            </div>
        </div>
    </section>
    <div class="">
        <!-- Footer -->
        <footer class="text-center text-lg-start text-white" style="background: #FF4E50;  
              background: -webkit-linear-gradient(to left, #ffb34f, #FF4E50);  
              background: linear-gradient(to left, hsla(34, 100%, 65%, 0.651), hsla(359, 100%, 65%, 0.644))">
          <!-- Grid container -->
          <div class="container p-4 pb-0">
            <!-- Section: Links -->
            <section class="">
              <!--Grid row-->
              <div class="row">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                  <h6 class="text-uppercase mb-4 font-weight-bold">
                    Legal
                  </h6>
                  <p>
                    &copy; 2024 ElectroWorld. Todos los derechos reservados.
                  </p>
                </div>
                <!-- Grid column -->
    
                <hr class="w-100 clearfix d-md-none" />
    
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                  <h6 class="text-uppercase mb-4 font-weight-bold">Contacto</h6>
                  <p>
                    <a href="mailto:alexandercp998@gmail.com" class="text-white">alexandercp998@gmail.com</a>
                  </p>
                  <p>
                    <a href="mailto:gabocastro2003@gmail.com" class="text-white">gabocastro2003@gmail.com</a>
                  </p>
                </div>
                <!-- Grid column -->
                <hr class="w-100 clearfix d-md-none" />
                <!-- Grid column -->
    
                <!-- Grid column -->
                <div class="col-md-3 col-lg-3 col-xl-2 mx-auto mt-3">
                  <h6 class="text-uppercase mb-4 font-weight-bold">Telefonos</h6>
                  <p>0987665505</p>
                  <p>0984663066</p>
                </div>
                <!-- Grid column -->
                <hr class="w-100 clearfix d-md-none" />
                <div class="col-md-3 col-lg-3 col-xl-2 mx-auto mt-3">
                  <h6 class="text-uppercase mb-4 font-weight-bold">Telefonos</h6>
                  <p>Carapungo y<br>Pje.Monterrey</p>
                </div>
                <!-- Grid column -->
                <div class="col-2 mx-auto mt-2">
                  <h6 class="text-uppercase mb-4 font-weight-bold">Redes Sociales</h6>
    
                  <!-- Facebook -->
                  <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="https://www.facebook.com/people/Gabo-Castro/pfbid0311BethBjm2ErBtADaJ8ZRwoKNReJD4xutZEVNruyVehBj7GZn9KqUoXJuQYtDQibl/?mibextid=ZbWKwL" role="button"><i
                      class="fab fa-facebook-f"></i></a>
    
                  <!-- Twitter -->
                  <a class="btn btn-primary btn-floating m-1" style="background-color: black" href="https://twitter.com/ElkksGabo" role="button"><i
                      class="fab fa-x-twitter"></i></a>
    
                  <!-- Instagram -->
                  <a class="btn btn-primary btn-floating m-1" style="background: #f09433; 
                   background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); 
                   background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 
                   background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); "
                    href="https://www.instagram.com/gabo_the_shit0?igsh=Z3Z3NTdiM2g4cm42" role="button"><i class="fab fa-instagram"></i></a>
    
                  <!-- Linkedin -->
                  <a class="btn btn-primary btn-floating m-1" style="background-color: black" href="https://www.tiktok.com/@monsterdexx?_t=8jMnQ1Q6MI2&_r=1" role="button"><i
                      class="fab fa-tiktok"></i></a>
                </div>
              </div>
              <!--Grid row-->
            </section>
            <!-- Section: Links -->
          </div>
          <!-- Grid container -->
        </footer>
        <!-- Footer -->
      </div>
      <!-- End of .container -->
    <script src="{{asset('js/nav_encabezado.js')}}"></script>
    <script src="{{asset('js/productos.js')}}"></script>
</body>


</html>