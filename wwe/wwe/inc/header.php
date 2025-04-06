<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/wwe/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/wwe/css/styles.css">
    <script src="/wwe/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/wwe/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <title>WWE - <?= $title ?></title>
</head>
<body>
    <div class="banner">
        <nav class="container-fluid d-flex justify-content-between align-items-center p-3 ps-5 pe-5"
            <a href="/wwe">
                <img src="/wwe/img/logo.png" alt="Logo" id="logo" class="img-fluid">
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
                            <img src="/wwe/img/acc.png"
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
                        <img src="/wwe/img/acc.png"
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
    </div>
    <script>
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.add('show');
        });
        
        document.getElementById('closeMenuButton').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.remove('show');
        });
    </script>