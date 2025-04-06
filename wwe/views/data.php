<?php

include __DIR__.'/../inc/header.php';

?>

<style>
    .tabs {
        width: 80vh;
    }

    .presentation {
        width: 75vh;
        text-align: justify;
        color: black;
        padding: 5%;
    }

    .pres_container {
        display: flex;
        justify-content: center;

    }

    .core {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    @media (max-width: 991px) {
        .nav {
            display: flex;
            flex-direction: column;
        }

        .tabs {
            width: 100%;
        }

        tr td:last-child {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            padding: 10px;
        }
    }
</style>

<div class="pres_container">
    <p class="presentation mt-5">
        Bienvenue sur la page de données brutes, vous retrouverez
        ici toute notre base de données sur le catch, vous pouvez
        visualiser, ajouter, modifier ou bien supprimer des catcheurs,
        des matches ou encore des évènements....
    </p>
</div>
<div class="core">
    <div class="tabs">
        <ul class="nav nav-underline nav-fill m-4">
            <li class="nav-item">
                <a class="nav-link text-dark" aria-current="page" href="/wwe/data/wrestlers/list">Catcheurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" aria-current="page" href="/wwe/data/matches/list">Matches</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" aria-current="page" href="/wwe/data/events/list">Évènements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" aria-current="page" href="/wwe/data/locations/list">Lieux</a>
            </li>
        </ul>
    </div>

    <?php
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
<hr>