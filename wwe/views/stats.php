<?php
include __DIR__."/../inc/header.php";
?>

<style>
    tr th:nth-child(4) {
        display: none;
    }

    tr td:nth-child(4) {
        display: none;
    }
</style>

<!-- CLASSEMENT WINRATE -->
<div class="container">

    <form method="get" class="mb-4">
        <div class="form-group">
            <label class="mt-3">Nombre minimum de matchs disputés :</label>
            <input type="number" 
                   name="min_matches" 
                   class="form-control" 
                   value="<?= htmlspecialchars($min_matches) ?>"
                   min="1"
                   style="max-width: 200px;">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
    </form>


    <?php if (!empty($best_winrates)): ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Catcheur</th>
                    <th>Victoires</th>
                    <th>Défaites</th>
                    <th>Total matchs</th>
                    <th>Winrate (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php $rang = 1; ?>
                <?php foreach ($best_winrates as $wrestler): ?>
                    <tr>
                        <td><?= $rang++ ?></td>
                        <td><?= htmlspecialchars($wrestler['nom']) ?></td>
                        <td><?= $wrestler['victoires'] ?></td>
                        <td><?= $wrestler['defaites'] ?></td>
                        <td><?= $wrestler['total_matches'] ?></td>
                        <td><?= number_format($wrestler['winrate'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">Aucun catcheur trouvé avec ces critères</div>
    <?php endif; ?>
</div>


<!-- EMPLACEMENT DES MATCHS -->
<?php
$sql_locations = "SELECT l.name AS location, COUNT(*) AS count 
                  FROM matches m
                  JOIN cards c ON m.card_id = c.id
                  JOIN locations l ON c.location_id = l.id
                  GROUP BY l.name
                  ORDER BY count DESC";
$stmt_locations = $db->prepare($sql_locations);
$stmt_locations->execute();
$locations = $stmt_locations->fetchAll(PDO::FETCH_ASSOC);

$locationLabels = [];
$locationCounts = [];
foreach ($locations as $loc) {
    $locationLabels[] = $loc['location'];
    $locationCounts[] = $loc['count'];
}
?>

<div class="container mt-5">
    <canvas id="locationsChart"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('locationsChart').getContext('2d');
    const locationsChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($locationLabels) ?>,
            datasets: [{
                label: 'Nombre de matchs',
                data: <?= json_encode($locationCounts) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                    // background
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                    // foreground
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Emplacements géographiques les plus utilisés pour les matchs'
                }
            }
        }
    });
</script>

<?php include __DIR__."/../inc/footer.php"; ?>