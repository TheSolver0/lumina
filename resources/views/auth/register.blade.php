<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from wpkixx.com/html/pitnik/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 17 Oct 2020 22:27:41 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>Pitnik Social Network Toolkit</title>
    <link rel="icon" href="{{ asset('assets/images/fav.png') }}" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


</head>

<body>
    <div class="www-layout">
        <section>
            <div class="gap no-gap signin whitish medium-opacity">
                <div class="bg-image" style="background-image:url(assets/images/resources/theme-bg.jpg)"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="big-ad">
                                <figure><img src="{{ asset('assets/images/logo2.png') }}" alt=""></figure>
                                <h1>Bienvenue sur LUMINA</h1>
                                <p>
                                    LUMINA est un reseau social innovant dediee aux universites. Sa mission est de
                                    fluidifier l'information sur tout ce qui concerne le domaine universitaire.
                                    Rejoignez-nous pour découvrir, partager et interagir avec des amis, camarades et des
                                    clubs universitaire. Inscrivez-vous dès aujourd'hui et faites partie de notre
                                    communauté en pleine croissance!
                                </p>

                                <div class="fun-fact">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="fun-box">
                                                <i class="ti-check-box"></i>
                                                <h6>Nombres de visiteurs</h6>
                                                <span>1,01,242</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="fun-box">
                                                <i class="ti-layout-media-overlay-alt-2"></i>
                                                <h6>Nombres de posts publies</h6>
                                                <span>21,03,245</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="fun-box">
                                                <i class="ti-user"></i>
                                                <h6>Nombres d'universites </h6>
                                                <span>40</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="we-login-register">
                                <div class="form-title">
                                    <i class="fa fa-key"></i>Inscription
                                    <span>Connectez vous et profitez de tout ce que LUMINA a à offrir.</span>
                                </div>
                                <form class="we-form" method="post">
                                    @csrf
                                    <input type="text" placeholder="Nom" name="name">
                                    <input type="text" placeholder="Email" name="email">
                                    <input type="password" placeholder="Mot de passe" name="password">
                                    <input type="password" placeholder="Mot de passe confirme" name="password_confirmation">
                                    <i class="icofont-eye-open" id="open"
                                            style="color:#9700ff; position: absolute;top:20px; right: 20px;"></i>
                                    <i class="icofont-eye-blocked" id="close"
                                            style="display: none;position: absolute;top:20px; right: 20px;"></i>
                                       
                                    <input type="checkbox"><label>se souvenir de moi</label>
                                    <button type="submit" data-ripple="">connexion</button>
                                    <a class="forgot underline" href="#" title="">mot de passe oublie?</a>
                                </form>
                                <a class="with-smedia facebook" href="#" title="" data-ripple=""><i
                                        class="fa fa-facebook"></i></a>
                                <a class="with-smedia twitter" href="#" title="" data-ripple=""><i
                                        class="fa fa-twitter"></i></a>
                                <a class="with-smedia instagram" href="#" title="" data-ripple=""><i
                                        class="fa fa-instagram"></i></a>
                                <a class="with-smedia google" href="#" title="" data-ripple=""><i
                                        class="fa fa-google-plus"></i></a>
                                <span>vous n'avez pas de compte? <a class="we-account underline" href="#"
                                        title="">s'inscrire maintenant</a></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(() => {
            $("form").submit(function(event) {
                event.preventDefault();
                // Désactiver le bouton de soumission
                $(this).find('button[type="submit"]').prop('disabled', true);

                // Récupérer les données du formulaire
                var formData = $(this).serialize();
                console.log('formData', formData);
                // Envoyer les données via AJAX
                $.ajax({
                    type: "POST", // ou GET selon votre configuration
                    url: "/register", // l'url de soumission
                    data: formData,
                    // processData: false,
                    // contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Cool'
                        });

                        setTimeout(() => {
                            window.location.href = '/';
                            // window.location.href = redirectUrl;
                        }, 1000);


                        // setTimeout(function() {
                        //     window.location.href = /profil;
                        // }, 2000);
                    },
                    error: function(e) {
                        console.log('message ', e.responseJSON.error);
                        Swal.fire({
                            title: 'Error!',
                            text: e.responseJSON.error,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });

            });

            $("#open").click(() => {
                document.querySelector("#password").type = "text";
                $("#open").hide();
                $("#close").show();
            });
            $("#close").click(() => {
                document.querySelector("#password").type = "password";
                $("#close").hide();
                $("#open").show();
            });
        });
    </script>

</body>

</html>
