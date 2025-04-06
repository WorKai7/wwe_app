<?php

$title = "Statistiques";

if (!$db instanceof PDO) {
    die("Erreur de connexion à la base de données.");
}

$min_matches = 100;
if (isset($_GET['min_matches']) && is_numeric($_GET['min_matches'])) {
    $min_matches = max(1, (int)$_GET['min_matches']);
}

$sql = "SELECT 
            nom, 
            victoires, 
            defaites, 
            (victoires + defaites) as total_matches,
            ROUND((victoires * 100.0 / (victoires + defaites)), 2) as winrate 
        FROM wrestlers_matches 
        WHERE (victoires + defaites) >= :min_matches 
        ORDER BY winrate DESC
        LIMIT 20";

$stmt = $db->prepare($sql);
$stmt->bindParam(':min_matches', $min_matches, PDO::PARAM_INT);
$stmt->execute();
$best_winrates = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>