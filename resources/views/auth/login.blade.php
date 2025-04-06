<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>Fitrium</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/apple.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/favicon.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/favicon.png')}}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/core.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/icon-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');

        document.addEventListener("DOMContentLoaded", function() {
            let loginBox = document.querySelector(".login-box");
            loginBox.style.opacity = "0";
            setTimeout(() => {
                loginBox.style.opacity = "1";
                loginBox.style.animation = "fadeInUp 0.8s ease-out";
            }, 500); // Retraso de 500ms antes de iniciar la animación
        });
    </script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>

</head>

<body class="login-page" style="background-color: #d3d3d3;">
    <div class="login-header box-shadow" style="background-color:rgb(46, 45, 45);">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="#" class="d-flex align-items-center">
                    <img src="inicio/images/11 (3).jpg" alt="Logo" style="width: 350px; height: 70px; margin-right: 10px;">
                    <span style="font-size: 20px; font-weight: bold; color: #fff;"></span>
                </a>
            </div>
            <a href="{{ url('/') }}" class="ml-auto text-white" style="color: white; font-size: 18px; text-decoration: none;">
                Home
            </a>
        </div>
    </div>

    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <div style="position: relative; display: inline-block; text-align: center;">
                        <h2 style="position: absolute; top: 0%; left: 50%; transform: translateX(-50%);
                               font-family: 'Roboto', sans-serif; color: #fff; font-size: 5rem;
                               font-weight: bold; text-transform: uppercase; letter-spacing: 10px;
                               text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8), 0 0 25px #000, 0 0 5px #000;">
                        </h2>
                        <img src="{{asset('inicio/images/11 (2).jpg')}}" alt="" style="width: 100%; border-radius: 10px;">
                    </div>

                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary" style="color:rgb(0, 0, 0) !important;">Iniciar Sesion</h2>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group custom">
                                <input id="email" type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Correo">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input id="password" type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Contraseña">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="forgot-password"><a href="{{ route('password.request') }}">Has olvidado tu contraseña</a></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit" style="background-color:rgb(0, 0, 0); color: white;">
                                            {{ __('Iniciar Session  ') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>