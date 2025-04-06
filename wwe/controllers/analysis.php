<?php
$title = "Analyse";

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