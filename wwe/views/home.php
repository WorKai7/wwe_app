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
        }
    </style>
</head>
<body>
    <div class="banner_container">
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
            
            <div class="pres_div">
                <p class="presentation">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Nullam in turpis ut augue eleifend cursus ac nec odio.
                    Aenean efficitur mi nisi, ut suscipit nunc gravida sed.
                    Morbi congue, massa a ullamcorper mattis, justo purus elementum nibh,
                    et tempor ligula erat sed ante. Vivamus sed dictum nibh.
                    Integer aliquet lectus sit amet iaculis fermentum.
                    Phasellus laoreet maximus vestibulum. Nulla eget rhoncus justo.
                    Maecenas in ligula erat. Morbi blandit arcu at turpis bibendum interdum eget nec odio.
                    Proin posuere ac ante non pellentesque. Vestibulum lectus massa,
                    feugiat sed malesuada in, hendrerit at mi. Aenean nisi turpis,
                    pellentesque vitae interdum eget, rhoncus ut arcu.
                </p>
            </div>
        </div>
    </div>
    <img src="img/home.jpeg" class="overflow-image">
</body>
</html>