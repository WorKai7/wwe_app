<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <title>WWE - Accueil</title>

    <style>
        .banner_container {
            position: relative;
        }

        .banner {
            background-image: url("img/banner.jpeg");
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }

        .overflow-image {
            position: absolute;
            height: 45vh;
            right: 10%;
            bottom: 10vh;
            z-index: 2;
            transition: all 0.3s ease;
            border-radius: 20px;
        }

        .overflow-image:hover {
            transform: scale(1.01);
        }

        nav {
            display: flex;
            padding: 0 50px 0 50px;
            justify-content: space-between;
            align-items: center;
        }

        #logo {
            height: 125px;
        }

        #acc {
            height: 50px;
        }

        .nav-link {
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            position: relative; /* Nécessaire pour positionner ::before */
            padding-bottom: 5px; /* Espace pour l'animation */
            display: inline-block; /* Pour contenir l'effet */
        }

        /* Animation de soulignement */
        .nav-link::before {
            content: "";
            position: absolute;
            display: block;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: white;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease;
        }

        .nav-link:hover::before {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .nav-link:hover {
            color: lightgray;
        }

        ul {
            gap: 150px;
            display: flex;
            align-items: center;
        }

        .dropdown-toggle-img {
            cursor: pointer;
            transition: transform 0.3s ease;
            border-radius: 50%; /* Pour un effet cercle */
            border: 2px solid transparent;
        }

        .dropdown-toggle-img:hover {
            transform: scale(1.1);
            border-color: #fff;
        }

        .dropdown-menu {
            min-width: 150px;
        }

        .pres_div {
            width: 35%;
            margin-left: 8%;
            margin-bottom: 9%;
        }

        .presentation {
            color: white;
            font-weight: bold;
            text-align: justify;
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .mobile-menu {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.show {
            transform: translateX(0);
        }
        
        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
        }
        
        .close-menu {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            background: none;
            border: none;
        }
        
        @media (min-width: 992px) {
            .mobile-menu-btn {
                display: none;
            }
        }
        
        @media (max-width: 991px) {
            .desktop-nav {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }

            .overflow-image {
                display: none;
            }

            .pres_div {
                width: 100%;
                margin: 0;
                padding: 5%;
            }

            .banner {
                height: 100%;
            }

            .dropdown {
                width: 25%;
            }

            ul {
                list-style: none;
            }

            li:last-child {
                display: flex;
                justify-content: center;
            }
        }

    </style>
</head>
<body>
    <div class="banner_container">
        <div class="banner">
            <nav class="container-fluid d-flex justify-content-between align-items-center p-3 ps-5 pe-5"
                <a href="/wwe">
                    <img src="img/logo.png" alt="Logo" id="logo" class="img-fluid">
                </a>
                
                <button class="navbar-toggler mobile-menu-btn d-lg-none" type="button" id="mobileMenuButton">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="desktop-nav d-none d-lg-block">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/wwe">ACCUEIL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/wwe/data">DONNÉES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/wwe/stats">STATISTIQUES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/wwe/analysis">ANALYSE</a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <img src="img/acc.png"
                                    id="acc"
                                    class="dropdown-toggle-img img-fluid"
                                    height="50"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    alt="Menu utilisateur">

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header">Connecté en tant que</h6></li>
                                    <li><span class="dropdown-item-text"><?= $_SESSION['user']['username'] ?? 'Utilisateur' ?></span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="delog.php">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="mobile-menu" id="mobileMenu">
                <button class="close-menu" id="closeMenuButton">&times;</button>
                
                <ul class="mobile-nav">
                    <li>
                        <a class="nav-link" href="/wwe">ACCUEIL</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/wwe/data">DONNÉES</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/wwe/stats">STATISTIQUES</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/wwe/analysis">ANALYSE</a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <img src="img/acc.png"
                                id="acc-mobile"
                                class="dropdown-toggle-img img-fluid"
                                height="50"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                alt="Menu utilisateur">

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Connecté en tant que</h6></li>
                                <li><span class="dropdown-item-text"><?= $_SESSION['user']['username'] ?? 'Utilisateur' ?></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="delog.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="pres_div">
                <p class="presentation">
                La World Wrestling Entertainment (WWE) est la plus grande entreprise de catch au monde, 
                mêlant sport et divertissement spectaculaire depuis 1952. Diffusée dans plus de 145 pays, 
                elle propose des shows emblématiques comme Raw, SmackDown et WrestleMania, avec des catcheurs 
                légendaires et des intrigues captivantes. Après sa fusion avec l'UFC en 2023 sous le groupe 
                TKO Holdings, et un accord majeur avec Netflix en 2024, la WWE continue de dominer le paysage 
                du divertissement sportif malgré certaines controverses.

                Ce site permet aux fans et aux analystes d’explorer des données détaillées sur les matchs,
                les catcheurs et les statistiques historiques. Grâce à des outils d’analyse avancés, il est possible
                de générer des prédictions pour les rencontres à venir, en se basant sur les performances passées, 
                les rivalités en cours et d’autres facteurs clés. Que vous soyez un passionné souhaitant anticiper 
                les résultats ou un expert cherchant à approfondir votre stratégie, cette plateforme offre des insights 
                précieux pour mieux comprendre l’univers dynamique de la WWE.
                </p>
            </div>
        </div>
    </div>
    <img src="img/home.jpeg" class="overflow-image">
    <script>
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.add('show');
        });
        
        document.getElementById('closeMenuButton').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.remove('show');
        });
    </script>
</body>
</html>