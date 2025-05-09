<!-- /*
* Template Name: Property
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="icon" href="{{asset('cuartos/lgo/logo (2).png')}}" type="image/x-icon" />


    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

</head>

<link rel="stylesheet" href="{{asset('inicio/fonts/icomoon/style.css')}}" />
<link rel="stylesheet" href="{{asset('inicio/fonts/flaticon/font/flaticon.css')}}" />

<link rel="stylesheet" href="{{asset('inicio/css/tiny-slider.css')}}" />
<link rel="stylesheet" href="{{asset('inicio/ss/aos.css')}}" />
<link rel="stylesheet" href="{{asset('inicio/css/style.css')}}" />

<title>
    FITRIUM
</title>
</head>

<body>
    <div class="site-mobile-menu site-navbar-target ">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav ">
        <div class="container ">
            <div class="menu-bg-wrap ">
                <div class="site-navigation ">
                    <a href="#" class="logo m-0 float-start">FITRIUM
                        <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end ">
                            <li class="active"><a href=""></a></li>

                            <li>
                                <div
                                    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                                    @if (Route::has('login'))
                                                            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                                                                @auth
                                                                    <a href="{{ url('/home') }}">Home</a>
                                                                @else
                                                                    <li class="active"><a href="{{ route('login') }}" class="active">Iniciar Sesion</a></li>


                                                                @endauth
                                        </div>
                                    @endif
                </li>
                </ul>

                <a href="#"
                    class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
                    data-toggle="collapse" data-target="#main-navbar">
                    <span></span>
                </a>
            </div>
        </div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-slide">
            <div class="img overlay prueba" style="background-image: url('{{asset('inicio/images/11 (2).jpg')}}')">
            </div>
            <div class="img overlay prueba" style="background-image: url('{{asset('inicio/images/11 (3).jpg')}}')">
            </div>

        </div>


    </div>
    <div class="section">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="font-weight-bold text-primary heading">
                        Paquetes
                    </h2>
                </div>

            </div><br>
            <div class="row">
                <div class="col-12">
                    <div class="property-slider-wrap">
                        <div class="col-md-6 text-md-end">
                            <div id="property-nav">
                                <span class="prev" data-controls="prev">Atras</span>

                                <span class="next" data-controls="next">Siguiente</span>
                            </div>
                        </div>
                        <div class="property-slider">
                            <div class="property-item">
                                <a href="property-single.html" class="img">
                                    <img src="{{ asset('inicio/images/session.jpg') }}" alt="Image" class="img-fluid" />
                                </a>

                                <div class="property-content">
                                    <div class="price mb-2"><span>Bs 10. / Session</span></div>
                                    <div>
                                        <span class="d-block mb-2 text-black-50">Paquete Session</span>
                                        <span class="city d-block mb-3">Incluye acceso ilimitado</span>

                                        <div class="specs d-flex mb-4">
                                            <span class="d-block d-flex align-items-center me-3">
                                                <span class="icon-user me-2"></span> <!-- Icono de usuario -->
                                                <span class="caption">1 Persona</span>
                                            </span>
                                            <span class="d-block d-flex align-items-center">
                                                <span class="icon-calendar me-2"></span> <!-- Icono de calendario -->
                                                <span class="caption">1 día</span>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!-- .item -->

                            <div class="property-item">
                                <a href="property-single.html" class="img">
                                    <img src="{{ asset('inicio/images/semanal.jpg') }}" alt="Image" class="img-fluid" />
                                </a>

                                <div class="property-content">
                                    <div class="price mb-2"><span>Bs 50 / semanal</span></div>
                                    <div>
                                        <span class="d-block mb-2 text-black-50">Paquete Semanal</span>
                                        <span class="city d-block mb-3">Incluye acceso ilimitado</span>

                                        <div class="specs d-flex mb-4">
                                            <span class="d-block d-flex align-items-center me-3">
                                                <span class="icon-user me-2"></span> <!-- Icono de usuario -->
                                                <span class="caption">1 Persona</span>
                                            </span>
                                            <span class="d-block d-flex align-items-center">
                                                <span class="icon-calendar me-2"></span> <!-- Icono de calendario -->
                                                <span class="caption">6 días</span>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <!-- .item -->

                            <div class="property-item">
                                <a href="property-single.html" class="img">
                                    <img src="{{ asset('inicio/images/mes2.jpg') }}" alt="Image" class="img-fluid" />
                                </a>

                                <div class="property-content">
                                    <div class="price mb-2"><span>Bs 170 / mes</span></div>
                                    <div>
                                        <span class="d-block mb-2 text-black-50">Paquete Mensual</span>
                                        <span class="city d-block mb-3">Incluye acceso ilimitado</span>

                                        <div class="specs d-flex mb-4">
                                            <span class="d-block d-flex align-items-center me-3">
                                                <span class="icon-user me-2"></span> <!-- Icono de usuario -->
                                                <span class="caption">1 Persona</span>
                                            </span>
                                            <span class="d-block d-flex align-items-center">
                                                <span class="icon-calendar me-2"></span> <!-- Icono de calendario -->
                                                <span class="caption">30 días</span>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="property-item">
                                <a href="property-single.html" class="img">
                                    <img src="{{ asset('inicio/images/estudiante.jpg') }}" alt="Image"
                                        class="img-fluid" />
                                </a>

                                <div class="property-content">
                                    <div class="price mb-2"><span>Bs 150 / mes Estudiante</span></div>
                                    <div>
                                        <span class="d-block mb-2 text-black-50">Paquete Estudiante</span>
                                        <span class="city d-block mb-3">Incluye acceso ilimitado</span>

                                        <div class="specs d-flex mb-4">
                                            <span class="d-block d-flex align-items-center me-3">
                                                <span class="icon-user me-2"></span> <!-- Icono de usuario -->
                                                <span class="caption">1 Persona</span>
                                            </span>
                                            <span class="d-block d-flex align-items-center">
                                                <span class="icon-calendar me-2"></span> <!-- Icono de calendario -->
                                                <span class="caption">30 días</span>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!-- .item -->

                            <div class="property-item">
                                <a href="property-single.html" class="img">
                                    <img src="{{ asset('inicio/images/cumpleañero.jpg') }}" alt="Image"
                                        class="img-fluid" />
                                </a>

                                <div class="property-content">
                                    <div class="price mb-2"><span>Bs 100 / mes Cumpleañero</span></div>
                                    <div>
                                        <span class="d-block mb-2 text-black-50">Paquete Cumpleañero</span>
                                        <span class="city d-block mb-3">Incluye acceso ilimitado</span>

                                        <div class="specs d-flex mb-4">
                                            <span class="d-block d-flex align-items-center me-3">
                                                <span class="icon-user me-2"></span> <!-- Icono de usuario -->
                                                <span class="caption">1 Persona</span>
                                            </span>
                                            <span class="d-block d-flex align-items-center">
                                                <span class="icon-calendar me-2"></span> <!-- Icono de calendario -->
                                                <span class="caption">30 días</span>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="section section-4 bg-light">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-lg-5">
                        <h2 class="font-weight-bold heading text-primary mb-4">
                            El gimnasio perfecto para ti
                        </h2>
                        <p class="text-black-50">
                            ¡Energía! Recuerda tus objetivos y no te rindas: el esfuerzo de hoy será recompensado.
                        </p>
                    </div>
                </div>
                <div class="row justify-content-between mb-5">
                    <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2">
                        <div class="img-about dots">
                            <img src="{{ asset('inicio/images/11 (2).jpg') }}" alt="Image" class="img-fluid" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex feature-h">
                            <span class="wrap-icon me-3">
                                <span class="icon-home2"></span>
                            </span>
                            <div class="feature-text">
                                <h3 class="heading">Clientes</h3>
                                <p class="text-black-50">
                                    Buscadores de la excelencia": destaca su búsqueda constante de mejorar su condición
                                    física.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex feature-h">
                            <span class="wrap-icon me-3">
                                <span class="icon-person"></span>
                            </span>
                            <div class="feature-text">
                                <h3 class="heading">Maquinas</h3>
                                <p class="text-black-50">
                                    Tecnología de vanguardia para un cuerpo de élite": resalta la calidad y la
                                    innovación de tus máquinas.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex feature-h">
                            <span class="wrap-icon me-3">
                                <span class="icon-security"></span>
                            </span>
                            <div class="feature-text">
                                <h3 class="heading">Productos</h3>
                                <p class="text-black-50">
                                    Alimentación inteligente para un cuerpo saludable": enfatiza la importancia de una
                                    nutrición equilibrada.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="section">
            <div class="row justify-content-center footer-cta" data-aos="fade-up">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="mb-4">Sea parte de Fitrium</h2>
                    <p>
                        <a href="#" class="btn btn-primary text-white py-3 px-4">Inciar Sesion</a>
                    </p>
                </div>
                <!-- /.col-lg-7 -->
            </div>
            <!-- /.row -->
        </div>


        <div class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="widget">
                            <h3>Ubicacion</h3>
                            <address>Av Fabril Esquina C/Peru</address>
                            <ul class="list-unstyled links">
                                <li><a href="https://api.whatsapp.com/send/?phone=78538094">+591 75018746</a></li>
                                
                                
                            </ul>
                        </div>
                        <!-- /.widget -->
                    </div>
                    <!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="widget">
                            
                            
                        </div>
                        <!-- /.widget -->
                    </div>
                    <!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="widget">
                            <h3>Redes Sociales</h3>
                            

                            <ul class="list-unstyled social">
                               <!-- <li>
                                    <a href="#"><span class="icon-instagram"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="icon-twitter"></span></a>
                                </li>-->
                                <li>
                                    <a href="https://www.facebook.com/profile.php?id=100083238343709"><span class="icon-facebook"></span></a>
                                </li>
                              <!--  <li>
                                    <a href="#"><span class="icon-linkedin"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="icon-pinterest"></span></a>
                                </li>
                                <li>
                                    <a href="#"><span class="icon-dribbble"></span></a>
                                </li>-->
                            </ul>
                        </div>
                        <!-- /.widget -->
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <!-- /.row -->

                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <!-- 
              **==========
              NOTE: 
              Please don't remove this copyright link unless you buy the license here https://untree.co/license/  
              **==========
            -->

                        <p>
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            . All Rights Reserved.
                        </p>
                        
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </div>
        <!-- /.site-footer -->

        <!-- Preloader -->
        <div id="overlayer"></div>
        <div class="loader">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <script src="{{asset('inicio/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('inicio/js/tiny-slider.js')}}"></script>
        <script src="{{asset('inicio/js/aos.js')}}"></script>
        <script src="{{asset('inicio/js/navbar.js')}}"></script>
        <script src="{{asset('inicio/js/counter.js')}}"></script>
        <script src="{{asset('inicio/js/custom.js')}}"></script>
</body>

<style>
    .prueba {
        backdrop-filter: blur(30px);
        box-shadow: 0px 0px 30px rgba(227, 228, 237, 0.37);
        border: 2px solid rgba(255, 255, 255, 0.18);
    }
</style>

</html>