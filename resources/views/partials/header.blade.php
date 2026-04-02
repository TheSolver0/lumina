<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lumina - Réseau social universitaire" />
    <title>LUMINA | Communication Universitaire</title>
    
    <link rel="icon" href="{{ asset('assets/images/ico.png') }}" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        function logout() {
            if(confirm('Voulez-vous vraiment vous déconnecter ?')) {
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) window.location.href = '/login';
                }).catch(error => console.error('Erreur:', error));
            }
        }
    </script>
</head>

<body>
    <div class="wavy-wraper">
        <div class="wavy">
            <span style="--i:1;">l</span>
            <span style="--i:2;">u</span>
            <span style="--i:3;">m</span>
            <span style="--i:4;">i</span>
            <span style="--i:5;">n</span>
            <span style="--i:6;">a</span>
        </div>
    </div>

    <div class="theme-layout">
        <div class="postoverlay"></div>
        
        <div class="responsive-header">
            <div class="mh-head first Sticky">
                <span class="mh-btns-left">
                    <a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
                </span>
                <span class="mh-text">
                    <a href="/" title="Lumina"><img src="{{ asset('assets/images/logo-6.png') }}" alt="Lumina Logo"></a>
                </span>
            </div>
            <div class="mh-head second">
                <form class="mh-form">
                    <input placeholder="Rechercher un cours, un étudiant..." />
                    <a href="#/" class="fa fa-search"></a>
                </form>
            </div>
        </div>
        
        <div class="topbar stick">
            <div class="logo">
                <a title="Lumina Accueil" href="/"><img src="{{ asset('assets/images/logo-6.png') }}" class="logo" alt="Lumina"></a>
            </div>
            <div class="top-area">
                <div class="top-search">
                    <form method="post">
                        <input type="text" placeholder="Rechercher un membre ou un forum...">
                        <button type="submit" data-ripple><i class="ti-search"></i></button>
                    </form>
                </div>

                <div class="page-name">
                    <span>Fil d'actualité</span>
                </div>

                <ul class="setting-area">
                    <li><a href="/" title="Accueil" data-ripple=""><i class="fa fa-home"></i></a></li>
                    <li><a href="/notifications" title="Notifications" data-ripple=""><i class="fa fa-bell"></i></a></li>
                    <li><a href="/help" title="Aide & Support" data-ripple=""><i class="fa fa-question-circle"></i></a></li>
                </ul>

                <div class="user-img">
                    @auth
                        <h5>{{ Auth::user()->name }}</h5>
                    @endauth
                    <img src="{{ asset('assets/images/resources/admin.jpg') }}" alt="Profile" class="pp">
                    <span class="status f-online"></span>
                    <div class="user-setting">
                        <span class="seting-title">Paramètres Utilisateur</span>
                        <ul class="log-out">
                            <li><a href="/profile" title=""><i class="ti-user"></i> Mon Profil</a></li>
                            <li><a href="/settings" title=""><i class="ti-pencil-alt"></i> Modifier Profil</a></li>
                            <li><a href="/activity" title=""><i class="ti-target"></i> Historique</a></li>
                            <li><a href="javascript:void(0);" onclick="logout();" title=""><i class="ti-power-off"></i> Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-sidebar left">
            <div class="menu-left">
                <ul class="left-menu">
                    <li>
                        <a href="/forum" title="Forums Académiques" data-toggle="tooltip" data-placement="right">
                            <i class="fa fa-university"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/favorites" title="Articles Enregistrés" data-toggle="tooltip" data-placement="right">
                            <i class="fa fa-bookmark"></i>
                        </a>
                    </li>
                    <li>
                        <a href="/faq" title="F.A.Q Étudiante" data-toggle="tooltip" data-placement="right">
                            <i class="ti-light-bulb"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="fixed-sidebar right">
            <div class="chat-friendz">
                <ul class="chat-users">
                    <li title="Faculté des Sciences">
                        <div class="author-thmb">
                            <img src="{{ asset('assets/images/resources/science-icon.png') }}" alt="Fac Sciences">
                        </div>
                    </li>
                    <li title="Faculté des Lettres">
                        <div class="author-thmb">
                            <img src="{{ asset('assets/images/resources/lettres-icon.png') }}" alt="Fac Lettres">
                        </div>
                    </li>
                </ul>
            </div>
        </div>