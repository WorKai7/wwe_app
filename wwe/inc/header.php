<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <title>WWW - <?= $title ?></title>

    <style>
        .banner {
            background-image: url("img/header_banner.jpeg");
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
            gap: 200px;
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
    </style>
</head>
<body>
    <div class="banner">
        <nav>
            <div>
                <a href="/wwe">
                    <img src="img/logo.png" alt="Logo" id="logo">
                </a>
            </div>

            <div>
                <ul class="nav">
                <li class="nav-item">
                        <a class="nav-link" href="/wwe">ACCUEIL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/wwe/stats">STATISTIQUES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/wwe/analysis">ANALYSE</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <!-- L'image comme bouton dropdown -->
                            <img src="img/acc.png"
                                id="acc"
                                class="dropdown-toggle-img"
                                height="50"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                alt="Menu utilisateur">

                            <!-- Menu dropdown -->
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Connecté en tant que</h6></li>
                                <li><span class="dropdown-item-text"><?= $_SESSION['user']['username'] ?? 'Utilisateur' ?></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
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
    </div>