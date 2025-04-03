<?php

include __DIR__.'/../../data.php';


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

    .table thead th:nth-child(1) {
        width: 20vh;
    }

    .table thead th:nth-child(2) {
        width: 75vh;
    }

</style>

<div class="main">    
    <div class="card mt-3" style="width: 75%;">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filtrer les catcheurs</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-5">
                    <label for="id" class="form-label">ID</label>
                    <input type="number" class="form-control" id="id" name="id" 
                           value="<?= $_GET['id'] ?? '' ?>" 
                           placeholder="ID du catcheur">
                </div>

                <div class="col-md-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?= $_GET['name'] ?? '' ?>" 
                           placeholder="Rechercher par nom...">
                </div>
                
                <div class="col-md-2 d-flex flex-column justify-content-end mb-2 align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="with_teams" name="with_teams" 
                               <?= $withTeams ? 'checked' : '' ?>>
                        <label class="form-check-label" for="with_teams">
                            Afficher les équipes
                        </label>
                    </div>
                </div>
                
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Filtrer</button>
                    <a href="?" class="btn btn-outline-secondary">×</a>
                </div>
            </form>
        </div>
    </div>

    <a href="/wwe/data/wrestlers/add" class="btn btn-primary m-5 w-25">Ajouter un catcheur</a>
    
    <nav>
        <ul class="pagination justify-content-center" style="gap: 0">
            <?php if ($currentPage > 2): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=1&with_teams=<?= $withTeams ?>">1</a>
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
                    <a class="page-link" href="?page=<?= $i ?>&with_teams=<?= $withTeams ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages - 1): ?>
                <?php if ($currentPage < $totalPages - 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $totalPages ?>&with_teams=<?= $withTeams ?>"><?= $totalPages ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($wrestlers as $wrestler): ?>
            <tr>
                <td><?= $wrestler->id ?></td>
                <td><?= $wrestler->name ?></td>
                <td>
                    <a href="/wwe/data/wrestlers/edit?id=<?= $wrestler->id ?>" class="btn btn-sm btn-secondary">Modifier</a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Supprimer</button>
                    <div class="modal fade" id="deleteModal" aria-hidden="true" aria-labelledby="deleteModalLabel" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-center">Êtes-vous sûr de vouloir supprimer le catcheur n°<?= $wrestler->id ?></h1>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-content p-3">
                                    <p>Cette action est irréversible</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <a href="/wwe/data/wrestlers/delete?id=<?= $wrestler->id ?>" class="btn btn-danger">Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <nav>
        <ul class="pagination justify-content-center" style="gap: 0">
            <?php if ($currentPage > 2): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=1&with_teams=<?= $withTeams ?>">1</a>
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
                    <a class="page-link" href="?page=<?= $i ?>&with_teams=<?= $withTeams ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages - 1): ?>
                <?php if ($currentPage < $totalPages - 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $totalPages ?>&with_teams=<?= $withTeams ?>"><?= $totalPages ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div class="text-center text-muted mt-2">
        Affichage des catcheurs <?= ($offset + 1) ?> à <?= min($offset + $itemsPerPage, $totalWrestlers) ?> sur <?= $totalWrestlers ?>
    </div>
</div>