<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/wwe/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>Page not found</title>

    <style>
        .not_found {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            width: 100%;
            height: 100vh;
        }

        img {
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        img:hover {
            transform: scale(1.01);
        }

        .left {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
    </style>
</head>
<body>
    <div class="not_found">
        <div class="left">
            <h1>404 : La page n'existe pas</h1>
            <a class="btn btn-primary" href="/wwe">Revenir à la page d'accueil</a>
        </div>
        <img src="/wwe/img/not_found.jpg" alt="Not found">
    </div>
</body>
</html>