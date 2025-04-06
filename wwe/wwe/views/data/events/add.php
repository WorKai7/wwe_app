<?php

include __DIR__.'/../../data.php';

?>

<style>
    .main {
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    .card {
        width: 75vh;
    }
</style>

<div class="main">
    <?php
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
    <div class="card m-3" style="width: 75%;">
        <div class="card-header">
            <h3 class="mb-0">Ajouter un évènement</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de l'évènement</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" placeholder="Ex: Royal Rumble 2025" required>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/wwe/data/events/list" class="btn btn-secondary me-md-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>