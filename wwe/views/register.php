<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>WWE - Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    <style>
        .fullscreen-bg {
            background: url('img/login_background.jpeg') no-repeat center center;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="fullscreen-bg d-flex flex-column">
        <div class="card p-3 mb-3">
            <div class="card-body">
                <h2 class="text-center mb-5">Inscription</h2>
                <form class="d-flex flex-column align-items-center" method="post">
                    <div class="mb-4">
                        <input class="form-control" type="text" placeholder="Nom d'utilisateur" name="uname" required>
                    </div>
                    <div class="mb-4">
                        <input class="form-control" type="password" placeholder="Mot de passe" name="psw" required>
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="password" placeholder="Confirmer votre mot de passe" name="confirm_psw" required>
                    </div>
                    <a class="mb-4" href="/wwe">Se connecter</a>
                    <?php if (is_null($db)) {
                    ?>
                        <button class="btn btn-danger" type="submit" name="connect" disabled>Impossible de s'inscrire</button>
                    <?php
                    } else {
                    ?>
                        <button class="btn btn-primary" type="submit" name="connect">S'inscrire</button>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>

        <?php
        if ($db) {
            $db = NULL;
        }
        if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['confirm'])) {
            foreach ($_SESSION['mesgs']['confirm'] as $mesg) {
        ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $mesg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            <?php
            }
            unset($_SESSION['mesgs']['confirm']);
        }
        if (is_array($_SESSION['mesgs']) && is_array($_SESSION['mesgs']['errors'])) {
            foreach ($_SESSION['mesgs']['errors'] as $err) {
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $err; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
        <?php
            }
            unset($_SESSION['mesgs']['errors']);
        }
        ?>

    </div>
    <div style="clear:both;"></div>
</body>

</html>