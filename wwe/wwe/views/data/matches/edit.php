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
    if (isset($_SESSION['mesgs']) && 
        is_array($_SESSION['mesgs']) && 
        isset($_SESSION['mesgs']['errors']) && 
        is_array($_SESSION['mesgs']['errors'])) {
        foreach ($_SESSION['mesgs']['errors'] as $err) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $err ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
            <?php
        }
        unset($_SESSION['mesgs']['errors']);
    }
    ?>
    <div class="card m-3" style="width: 75%;">
        <div class="card-header">
            <h3 class="mb-0">Modifier un match</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <!-- Dropdown pour le vainqueur -->
                <div class="mb-3">
                    <label for="winner_id" class="form-label">Vainqueur</label>
                    <select class="form-select" id="winner_id" name="winner_id" required>
                        <option value="">Sélectionnez un vainqueur</option>
                        <?php foreach ($wrestlers as $wrestler): ?>
                            <option value="<?= $wrestler->id ?>" 
                                <?= (isset($_POST['winner_id']) ? $_POST['winner_id'] : $match->winner_id) == $wrestler->id ? 'selected' : '' ?>>
                                <?= $wrestler->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dropdown pour le perdant -->
                <div class="mb-3">
                    <label for="loser_id" class="form-label">Perdant</label>
                    <select class="form-select" id="loser_id" name="loser_id" required>
                        <option value="">Sélectionnez un perdant</option>
                        <?php foreach ($wrestlers as $wrestler): ?>
                            <option value="<?= $wrestler->id ?>" 
                                <?= (isset($_POST['loser_id']) ? $_POST['loser_id'] : $match->loser_id) == $wrestler->id ? 'selected' : '' ?>>
                                <?= $wrestler->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dropdown pour le type de match -->
                <div class="mb-3">
                    <label for="match_type_id" class="form-label">Type de match</label>
                    <select class="form-select" id="match_type_id" name="match_type_id" required>
                        <option value="">Sélectionnez un type de match</option>
                        <?php foreach ($matchTypes as $type): ?>
                            <option value="<?= $type->id ?>" 
                                <?= (isset($_POST['match_type_id']) ? $_POST['match_type_id'] : $match->match_type_id) == $type->id ? 'selected' : '' ?>>
                                <?= $type->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Champ pour le type de victoire -->
                <div class="mb-3">
                    <label for="win_type" class="form-label">Type de victoire</label>
                    <input type="text" class="form-control" id="win_type" name="win_type" 
                           value="<?= $_POST['win_type'] ?? $match->win_type ?? '' ?>" 
                           placeholder="Ex: Tombé, Soumission, etc." required>
                </div>

                <!-- Champ pour la durée -->
                <div class="mb-3">
                    <label for="duration" class="form-label">Durée (format MM:SS)</label>
                    <input type="text" class="form-control" id="duration" name="duration" 
                           value="<?= $_POST['duration'] ?? $match->duration ?? '' ?>" 
                           placeholder="Ex: 12:34" required>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="/wwe/data/matches/list" class="btn btn-secondary me-md-2">Annuler</a>
                    <button type="submit" name="confirm_envoyer" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>