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
            <h5 class="mb-0">Filtrer les évènements</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-5">
                    <label for="id" class="form-label">ID</label>
                    <input type="number" class="form-control" id="id" name="id" 
                           value="<?= $_GET['id'] ?? '' ?>" 
                           placeholder="ID de l'évènement">
                </div>

                <div class="col-md-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?= $_GET['name'] ?? '' ?>" 
                           placeholder="Rechercher par nom...">
                </div>
                
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1" name="confirm_envoyer">Filtrer</button>
                    <a href="?" class="btn btn-outline-secondary">x</a>
                </div>
            </form>
        </div>
    </div>

    <a href="/wwe/data/events/add" class="btn btn-primary m-5 w-25">Ajouter un évènement</a>
    
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
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($events as $event): ?>
            <tr>
                <td><?= $event->id ?></td>
                <td><?= $event->name ?></td>
                <td>
                    <a href="/wwe/data/events/edit?id=<?= $event->id ?>" class="btn btn-sm btn-secondary">Modifier</a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $event->id ?>">Supprimer </button>
                    <div class="modal fade" id="deleteModal<?= $event->id ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer l'évènement #<?= $event->id ?></h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Êtes-vous sûr de vouloir supprimer cet évènement ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <a href="/wwe/data/events/delete?id=<?= $event->id ?>" class="btn btn-danger">Supprimer</a>
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
    
    <div class="text-center text-muted mt-2">
        Affichage des évènements <?= ($offset + 1) ?> à <?= min($offset + $itemsPerPage, $totalEvents) ?> sur <?= $totalEvents ?>
    </div>
</div>