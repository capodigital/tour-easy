<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="style.css" />

    <title>MAD MUSIC Tour Planner</title>

</head>

<body>
    <!--NavBar-->
    <div class="navBar">
        <!--Logo-->
        <div class="logo">
            <img src="img/logo.svg" />
        </div>
        <!--Botones centrales-->
        <div class="botonesCentrales">
            <button>About Us</button>
            <button>Services</button>
            <button>Contacts</button>
            <button>More</button>
            <button>Pricing</button>
        </div>
        <!--Sesion y registro-->
        <div class="botonesRegistro">
            <button class="botonLogin">Log In</button>
            <button class="botonRegistro">Sign Up</button>
        </div>
    </div>

    <!-- 2 Posts-->
    <div class="post_1">
        <div class="post_1_1">DISCOVER THE TOP ARTIST TOUR AGENCIES</div>
        <div class="post_1_2">Find the perfect agency to plan your dream artist tour</div>
    </div>

    <!--Primer Carrusel-->
    <div class="primerCarrusel">
        <img src="./img/foto-1.jpeg" alt="">
        <img src="./img/foto-2.jpeg" alt="">
        <img src="./img/foto-3.jpeg" alt="">
        <img src="./img/foto-4.jpeg" alt="">
        <img src="./img/foto-5.jpeg" alt="">
        <img src="./img/foto-6.jpeg" alt="">
        <img src="./img/foto-7.jpeg" alt="">
        <img src="./img/foto-8.jpeg" alt="">
    </div>

    <!--Botones Explore y Tours-->
    <div class="buttonWhite">
        <button>Explore</button>
        <button>Tours</button>
    </div>

    <!-- 2 Posts-->
    <div class="post_2">
        <div class="post_2_1">
            <div class="ours">Ours</div>
            <div class="agencies">agencies</div>
        </div>
        <div class="post_2_2">
            Our artist tour agency, we offer a wide range of services to ensure that you have an unforgettable
            experience
        </div>
    </div>

    <!--Segundo carrusel-->
    <div class="segundoCarrusel">
        <!-- Postal-1 -->
        <div class="postalContainer">
            <div class="nombrePostal">
                <div class="nombreNombrePostal">SPLASHI.CO</div>
                {{-- <img class="logoNombrePostal" src="img/splashi.png" alt=""> --}}
            </div>
            <div class="infoContainer">
                <div class="infoPostal">
                    Información
                </div>
                <div class="numeroPostal">
                    <img src="img/whatsapp.png" alt="" width="20" height="20">
                    <div>
                        <p>Número de teléfono</p>
                        <p class="numerNumeroPostal"> +34(900377023)</p>
                    </div>
                </div>
                <div class="numeroPostal">
                    <img src="img/mail.png" alt="" width="20" height="20">
                    <div>
                        <p>Correo electrónico</p>
                        <p class="numerNumeroPostal"> algunemail@gmail.com</p>
                    </div>
                </div>
            </div>
            {{-- <div class="etiquetaButton">
                <button class="etiquetaButtonLeft">Etiqueta</button>
                <button class="etiquetaButtonRight">Etiqueta</button>
            </div> --}}
        </div>
        <!-- Postal-2 -->
        <div class="postalContainer">
            <div class="nombrePostal">
                <div class="nombreNombrePostal">SPECTRUM</div>
                <img class="logoNombrePostal" src="img/spectrum.png" alt="">
            </div>
            <div class="infoContainer">
                <div class="infoPostal">
                    Info.
                </div>
                <div class="numeroPostal">
                    <img src="img/whatsapp.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal"> +34(900377023)</p>
                </div>
                <div class="numeroPostal">
                    <img src="img/mail.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal">algunemail@gmail.com</p>
                </div>
            </div>
            <div class="etiquetaButton">
                <button class="etiquetaButtonLeft">Etiqueta</button>
                <button class="etiquetaButtonRight">Etiqueta</button>
            </div>
        </div>
        <!-- Postal-3 -->
        <div class="postalContainer">
            <div class="nombrePostal">
                <div class="nombreNombrePostal">SPECTRUM</div>
                <img class="logoNombrePostal" src="img/spectrum.png" alt="">
            </div>
            <div class="infoContainer">
                <div class="infoPostal">
                    Info.
                </div>
                <div class="numeroPostal">
                    <img src="img/whatsapp.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal"> +34(900377023)</p>
                </div>
                <div class="numeroPostal">
                    <img src="img/mail.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal">algunemail@gmail.com</p>
                </div>
            </div>
            <div class="etiquetaButton">
                <button class="etiquetaButtonLeft">Etiqueta</button>
                <button class="etiquetaButtonRight">Etiqueta</button>
            </div>
        </div>
        <!-- Postal-4 -->
        <div class="postalContainer">
            <div class="nombrePostal">
                <div class="nombreNombrePostal">SPECTRUM</div>
                <img class="logoNombrePostal" src="img/spectrum.png" alt="">
            </div>
            <div class="infoContainer">
                <div class="infoPostal">
                    Info.
                </div>
                <div class="numeroPostal">
                    <img src="img/whatsapp.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal"> +34(900377023)</p>
                </div>
                <div class="numeroPostal">
                    <img src="img/mail.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal">algunemail@gmail.com</p>
                </div>
            </div>
            <div class="etiquetaButton">
                <button class="etiquetaButtonLeft">Etiqueta</button>
                <button class="etiquetaButtonRight">Etiqueta</button>
            </div>
        </div>
        <!-- Postal-5 -->
        <div class="postalContainer">
            <div class="nombrePostal">
                <div class="nombreNombrePostal">SPLASHI.CO</div>
                <img class="logoNombrePostal" src="img/splashi.png" alt="">
            </div>
            <div class="infoContainer">
                <div class="infoPostal">
                    Info.
                </div>
                <div class="numeroPostal">
                    <img src="img/whatsapp.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal"> +34(900377023)</p>
                </div>
                <div class="numeroPostal">
                    <img src="img/mail.png" alt="" width="10" height="10">
                    <p class="numerNumeroPostal">algunemail@gmail.com</p>
                </div>
            </div>
            <div class="etiquetaButton">
                <button class="etiquetaButtonLeft">Etiqueta</button>
                <button class="etiquetaButtonRight">Etiqueta</button>
            </div>
        </div>
    </div>

    <!-- Flayer HighLight -->
    <div class="highlightContainer">
        <!--Columna izquierda-->
        <div class="columnaIzquierda">
            <div>
                <div class="highlightingWord">Highlighting</div>
                <div class="highlightingText">The Uniqueness of Our Artist Tour Agency</div>
            </div>
            <div class="highlightingParraf">
                Our artist tour agency, we offer a wide range of services to ensure that you have an unforgettable
                experience. From personalized itineraries to vip access, we go above and beyond to make your tour
                exceptional.
            </div>
        </div>
        <!-- Columna derecha -->
        <div class="columnaDerecha">
            <!--Fila superior-->
            <div class="filaImagenes">
                <img src="img/highlight1.png" width="190" height="190" alt="">
                <img src="img/raulpaz.jpeg" width="160" height="190" alt="">
            </div>
            <!--Fila inferior-->
            <div>
                <img class="imagenExterna" src="img/highlight3.png" width="360" height="170" alt="">
            </div>
        </div>
    </div>

    <!-- Flayer Artist Collage -->
    <div>
        <div class="flayerTitle">
            <div class="now">now</div>
            <div class="tours">Tours</div>
            <div class="byArtist">by artist</div>
        </div>
        <div class="forthis">FOR THIS 2024</div>
        {{-- <img class="collage" src="img/collage.png" alt=""> --}}
        <div class="artists-container">
            <div>
            </div>
            <div>
            </div>
            <div>
            </div>
        </div>
    </div>

    <!-- Button MoreTours -->
    <div class="buttonWhite2">
        <button>MORE TOURS</button>
    </div>



</body>
<footer>
    <div class="footerList">
        <div class="listContainer">
            <!-- Features -->
            <div class="listTitle">Features</div>
            <div class="listText">
                <div>Layout</div>
                <div>CMS</div>
                <div>Localization</div>
                <div>Effects</div>
                <div>SEO & Perfomance</div>
                <div>Site Navigation</div>
                <div>Site Management</div>
                <div>Enterprise</div>
                <div>Developers</div>
            </div>
        </div>
        <div class="listContainer">
            <!-- Company -->
            <div class="listTitle">Company</div>
            <div class="listText">
                <div>Careers</div>
                <div>Hiring</div>
                <div>Security</div>
                <div>Privacy</div>
                <div>Abuse</div>
                <div>Charges</div>
                <div>Terms</div>
                <div>Cookies</div>
            </div>
        </div>

    </div>
    <!-- Flayer de marcas
  <div class="flayerDeMarcas">
      <div class="marcaContainer">
          <img src="img/marca1.png" alt="" width="100">
          <img src="img/marca2.png" alt="" width="130">
          <img src="img/marca3.png" alt="" width="130">
      </div>
      <div class="marcaContainer">
          <img src="img/publicidad1.png" alt="" width="130">
          <img src="img/publicidad2.png" alt="" width="130">
          <img src="img/publicidad3.png" alt="" width="130">
          <img src="img/publicidad4.png" alt="" width="130">
      </div>
  </div> -->
    <script src="landing.js"></script>
</footer>

</html>
