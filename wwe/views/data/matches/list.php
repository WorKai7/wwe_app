<?php

include __DIR__.'/../../data.php';
include __DIR__.'/../../../inc/utils.php';

?>


<style>
    .main {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .table {
        width: 75%;
    }

    .table thead th:nth-child(1) { width: 10%; }
    .table thead th:nth-child(2) { width: 20%; }
    .table thead th:nth-child(3) { width: 20%; }
    .table thead th:nth-child(4) { width: 15%; }
    .table thead th:nth-child(5) { width: 15%; }
</style>

<div class="main">    
    <div class="card mt-3" style="width: 75%;">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtrer les matches</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3 d-flex justify-content-center">
                <div class="col-md-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="number" class="form-control" id="id" name="id" 
                           value="<?= $_GET['id'] ?? '' ?>" 
                           placeholder="ID du match">
                </div>

                <div class="col-md-3">
                    <label for="winner_name" class="form-label">Nom du vainqueur</label>
                    <input type="text" class="form-control" id="winner_name" name="winner_name" 
                        value="<?= $_GET['winner_name'] ?? ''?>" 
                        placeholder="Rechercher par nom de vainqueur">
                </div>

                <div class="col-md-3">
                    <label for="loser_name" class="form-label">Nom du perdant</label>
                    <input type="text" class="form-control" id="loser_name" name="loser_name" 
                        value="<?= $_GET['loser_name'] ?? ''?>" 
                        placeholder="Rechercher par nom de perdant">
                </div>

                <div class="col-md-3">
                    <label for="match_type_name" class="form-label">Type de match</label>
                    <input type="text" class="form-control" id="match_type_name" name="match_type_name" 
                        value="<?= $_GET['match_type_name'] ?? '' ?>"
                        placeholder="Rechercher par type (ex: 'Royal rumble', 'Cage')">
                </div>
                
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1" name="confirm_envoyer">Filtrer</button>
                    <a href="?" class="btn btn-outline-secondary">x</a>
                </div>
            </form>
        </div>
    </div>

    <a href="/wwe/data/matches/add" class="btn btn-primary m-5 w-25">Ajouter un match</a>
    
    <nav>
        <ul class="pagination justify-content-center" style="gap: 0">
            <?php if ($currentPage > 2): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= buildPaginatedUrl(1, $_GET) ?>">1</a>
                </li>
                <?php if ($currentPage > 3): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php 
            $start = max(1, $currentPage - 1);
            $end = min($totalPages, $currentPage + 1);
            
            for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                    <a class="page-link" href="<?= buildPaginatedUrl($i, $_GET) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages - 1): ?>
                <?php if ($currentPage < $totalPages - 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link" href="<?= buildPaginatedUrl($totalPages, $_GET) ?>"><?= $totalPages ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vainqueur</th>
                <th>Perdant</th>
                <th>Type de match</th>
                <th>Durée</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($matches as $match): ?>
            <tr>
                <td><?= $match->id ?></td>
                <td><?= $match->winner_name ?></td>
                <td><?= $match->loser_name ?></td>
                <td><?= $match->match_type_name ?></td>
                <td><?= $match->duration ?></td>
                <td>
                    <a href="/wwe/data/matches/edit?id=<?= $match->id ?>" class="btn btn-sm btn-secondary">Modifier</a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $match->id ?>">
                        Supprimer
                    </button>
                    
                    <!-- Modal de suppression -->
                    <div class="modal fade" id="deleteModal<?= $match->id ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer le match #<?= $match->id ?></h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Êtes-vous sûr de vouloir supprimer ce match ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <a href="/wwe/data/matches/delete?id=<?= $match->id ?>" class="btn btn-danger">Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Pagination identique -->
    
    <div class="text-center text-muted mt-2">
        Affichage des matches <?= ($offset + 1) ?> à <?= min($offset + $itemsPerPage, $totalMatches) ?> sur <?= $totalMatches ?>
    </div>
</div>