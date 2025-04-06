<?php
include __DIR__."/../inc/header.php";

if (!$db instanceof PDO) {
    die("Erreur de connexion à la base de données.");
}

$show_teams = isset($_GET['show_teams']) ? filter_var($_GET['show_teams'], FILTER_VALIDATE_BOOLEAN) : false;

if ($show_teams) {
    $query = $db->query("SELECT id, name FROM wrestlers ORDER BY name");
} else {
    $query = $db->query("SELECT id, name FROM wrestlers WHERE name NOT ILIKE '%&%' ORDER BY name");
}
$wrestlers = $query->fetchAll(PDO::FETCH_ASSOC);
$wrestlers_json = json_encode($wrestlers);

$results = null;
$wrestler1 = null;
$wrestler2 = null;

if (isset($_POST['submit'])) {
    $wrestler1_id = $_POST['wrestler1_id'] ?? null;
    $wrestler2_id = $_POST['wrestler2_id'] ?? null;
    
    if ($wrestler1_id && $wrestler2_id) {
        if ($wrestler1_id == $wrestler2_id) {
            $error = "Veuillez sélectionner deux catcheurs différents.";
        } else {
            try {
                $stmt = $db->prepare("SELECT * FROM calculate_win_probability(:wrestler1_id, :wrestler2_id)");
                $stmt->bindParam(':wrestler1_id', $wrestler1_id, PDO::PARAM_INT);
                $stmt->bindParam(':wrestler2_id', $wrestler2_id, PDO::PARAM_INT);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $stmt1 = $db->prepare("SELECT name FROM wrestlers WHERE id = :id");
                $stmt1->bindParam(':id', $wrestler1_id, PDO::PARAM_INT);
                $stmt1->execute();
                $wrestler1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                
                $stmt2 = $db->prepare("SELECT name FROM wrestlers WHERE id = :id");
                $stmt2->bindParam(':id', $wrestler2_id, PDO::PARAM_INT);
                $stmt2->execute();
                $wrestler2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $error = "Erreur lors du calcul des probabilités : " . $e->getMessage();
            }
        }
    } else {
        $error = "Veuillez sélectionner deux catcheurs.";
    }
}
?>

<style>
    body, .container, .card, .card-body, label, .btn {
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem;
    }

    .container {
        margin-top: 60px;
    }
    
    .card-header h2 {
        font-size: 1.5rem;
    }
    
    .search-container {
        position: relative;
    }
    .search-results {
        position: absolute;
        width: 100%;
        max-height: 250px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        display: none;
    }
    .search-item {
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .search-item:hover {
        background-color: #f8f9fa;
    }
    .selected-wrestler {
        background-color: #e9ecef;
        padding: 8px 15px;
        border-radius: 0.25rem;
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .remove-wrestler {
        cursor: pointer;
        color: #dc3545;
        font-weight: bold;
    }
    .filter-option {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }
    .form-check-label {
        margin-left: 0.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        color: #212529;
    }
</style>

<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="mb-0">Analyse des probabilités de victoire</h2>
        </div>
        <div class="card-body">
            <div class="filter-option">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="show_teams" 
                        <?= $show_teams ? 'checked' : '' ?>>
                    <label class="form-check-label" for="show_teams">
                        Afficher les équipes/duos
                    </label>
                </div>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="post" action="" id="probability-form">
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="wrestler1_search"><strong>Catcheur 1 :</strong></label>
                            <div class="search-container">
                                <input type="text" id="wrestler1_search" class="form-control" placeholder="Rechercher un catcheur..."
                                   autocomplete="off">
                                <div class="search-results" id="wrestler1_results"></div>
                                <input type="hidden" name="wrestler1_id" id="wrestler1_id" 
                                    value="<?= isset($_POST['wrestler1_id']) ? $_POST['wrestler1_id'] : '' ?>">
                                <div id="wrestler1_selected" class="selected-wrestler" 
                                    style="<?= isset($_POST['wrestler1_id']) ? '' : 'display:none;' ?>">
                                    <?php 
                                        if (isset($_POST['wrestler1_id'])) {
                                            foreach ($wrestlers as $wrestler) {
                                                if ($wrestler['id'] == $_POST['wrestler1_id']) {
                                                    echo htmlspecialchars($wrestler['name']) . ' <span class="remove-wrestler" data-target="wrestler1">×</span>';
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <h4 class="mt-4">VS</h4>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="wrestler2_search"><strong>Catcheur 2 :</strong></label>
                            <div class="search-container">
                                <input type="text" id="wrestler2_search" class="form-control" placeholder="Rechercher un catcheur..."
                                   autocomplete="off">
                                <div class="search-results" id="wrestler2_results"></div>
                                <input type="hidden" name="wrestler2_id" id="wrestler2_id" 
                                    value="<?= isset($_POST['wrestler2_id']) ? $_POST['wrestler2_id'] : '' ?>">
                                <div id="wrestler2_selected" class="selected-wrestler" 
                                    style="<?= isset($_POST['wrestler2_id']) ? '' : 'display:none;' ?>">
                                    <?php 
                                        if (isset($_POST['wrestler2_id'])) {
                                            foreach ($wrestlers as $wrestler) {
                                                if ($wrestler['id'] == $_POST['wrestler2_id']) {
                                                    echo htmlspecialchars($wrestler['name']) . ' <span class="remove-wrestler" data-target="wrestler2">×</span>';
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mb-4">
                    <button type="submit" name="submit" id="submit-btn" class="btn btn-primary">Calculer les probabilités</button>
                </div>
            </form>
            
            <?php if ($results && $wrestler1 && $wrestler2): ?>
                <hr>
                <h3 class="text-center mb-4">Résultats de l'analyse</h3>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Catcheur</th>
                                <th>Probabilité de victoire</th>
                                <th>Représentation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result): ?>
                                <tr>
                                    <td>
                                        <strong>
                                            <?= $result['wrestler_id'] == $_POST['wrestler1_id'] ? htmlspecialchars($wrestler1['name']) : htmlspecialchars($wrestler2['name']) ?>
                                        </strong>
                                    </td>
                                    <td><?= number_format($result['win_probability'], 2) ?>%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" 
                                                style="width: <?= $result['win_probability'] ?>%;" 
                                                aria-valuenow="<?= $result['win_probability'] ?>" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                <?= number_format($result['win_probability'], 1) ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i> 
                    Ces probabilités sont calculées à partir de l'historique des matchs et des performances passées des catcheurs.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const allWrestlers = <?= $wrestlers_json ?>;
    let wrestlers = [...allWrestlers];
    
    const showTeamsCheckbox = document.getElementById('show_teams');
    
    showTeamsCheckbox.addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('show_teams', this.checked ? 'true' : 'false');
        window.location.href = url.toString();
    });
    
    setupSearchField('wrestler1');
    setupSearchField('wrestler2');
    
    document.querySelectorAll('.remove-wrestler').forEach(function(element) {
        element.addEventListener('click', function() {
            const target = this.dataset.target;
            clearSelection(target);
        });
    });
    
    function setupSearchField(fieldId) {
        const searchInput = document.getElementById(`${fieldId}_search`);
        const resultsContainer = document.getElementById(`${fieldId}_results`);
        const idInput = document.getElementById(`${fieldId}_id`);
        const selectedDiv = document.getElementById(`${fieldId}_selected`);
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length < 2) {
                resultsContainer.style.display = 'none';
                return;
            }
            
            const matchedWrestlers = wrestlers.filter(wrestler => 
                wrestler.name.toLowerCase().includes(query)
            );
            
            if (matchedWrestlers.length > 0) {
                resultsContainer.innerHTML = '';
                matchedWrestlers.forEach(wrestler => {
                    const item = document.createElement('div');
                    item.className = 'search-item';
                    item.textContent = wrestler.name;
                    item.addEventListener('click', function() {
                        selectWrestler(fieldId, wrestler.id, wrestler.name);
                        resultsContainer.style.display = 'none';
                    });
                    resultsContainer.appendChild(item);
                });
                resultsContainer.style.display = 'block';
            } else {
                resultsContainer.innerHTML = '<div class="search-item">Aucun résultat trouvé</div>';
                resultsContainer.style.display = 'block';
            }
        });
        
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
        
        searchInput.addEventListener('focus', function() {
            if (this.value.length >= 2) {
                resultsContainer.style.display = 'block';
            }
        });
    }
    
    function selectWrestler(fieldId, wrestlerId, wrestlerName) {
        const idInput = document.getElementById(`${fieldId}_id`);
        const searchInput = document.getElementById(`${fieldId}_search`);
        const selectedDiv = document.getElementById(`${fieldId}_selected`);
        
        idInput.value = wrestlerId;
        searchInput.value = '';
        selectedDiv.innerHTML = `${wrestlerName} <span class="remove-wrestler" data-target="${fieldId}">×</span>`;
        selectedDiv.style.display = 'flex';
        
        selectedDiv.querySelector('.remove-wrestler').addEventListener('click', function() {
            clearSelection(fieldId);
        });
        
        checkFormValidity();
    }
    
    function clearSelection(fieldId) {
        const idInput = document.getElementById(`${fieldId}_id`);
        const selectedDiv = document.getElementById(`${fieldId}_selected`);
        
        idInput.value = '';
        selectedDiv.innerHTML = '';
        selectedDiv.style.display = 'none';
        
        checkFormValidity();
    }
    
    function checkFormValidity() {
        const wrestler1Id = document.getElementById('wrestler1_id').value;
        const wrestler2Id = document.getElementById('wrestler2_id').value;
        const submitBtn = document.getElementById('submit-btn');
        
        if (wrestler1Id && wrestler2Id && wrestler1Id !== wrestler2Id) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
    
    checkFormValidity();
});
</script>

<?php
include __DIR__."/../inc/footer.php";
?>