<?php
include __DIR__.'/../../../class/wrestling_match.class.php';
include __DIR__.'/../../../class/wrestler.class.php';

$title = "Modifier un match";
$matchId = $_GET['id'] ?? null;

if (empty($matchId)) {
    $_SESSION["mesgs"]["errors"][] = "Aucun match sélectionné";
    header("Location: /wwe/data/matches/list");
    exit;
}

try {
    // Récupération des données pour les dropdowns
    $wrestlers = Wrestler::fetchAllSingle($db);
    $matchTypesQuery = $db->query("SELECT id, name FROM match_types ORDER BY name");
    $matchTypes = $matchTypesQuery->fetchAll(PDO::FETCH_OBJ);
    
    // Chargement du match à modifier
    $match = new WrestlingMatch($db);
    $match->fetch($matchId);
    
} catch (Exception $e) {
    $_SESSION["mesgs"]["errors"][] = "Erreur lors du chargement des données : " . $e->getMessage();
    header("Location: /wwe/data/matches/list");
    exit;
}

if (isset($_POST['confirm_envoyer'])) {
    try {
        // Validation des données
        $requiredFields = ['winner_id', 'loser_id', 'match_type_id', 'win_type', 'duration'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ " . str_replace('_', ' ', $field) . " est requis");
            }
        }

        // Vérification que le vainqueur et le perdant sont différents
        if ($_POST['winner_id'] === $_POST['loser_id']) {
            throw new Exception("Le vainqueur et le perdant doivent être différents");
        }

        // Validation du format de durée
        if (!preg_match('/^\d{1,2}:\d{2}$/', $_POST['duration'])) {
            throw new Exception("Le format de durée doit être MM:SS");
        }

        // Mise à jour du match
        $match->winner_id = $_POST['winner_id'];
        $match->loser_id = $_POST['loser_id'];
        $match->match_type_id = $_POST['match_type_id'];
        $match->win_type = $_POST['win_type'];
        $match->duration = $_POST['duration'];
        
        $match->update();
        
        $_SESSION["mesgs"]['confirm'][] = "Match mis à jour avec succès!";
        header("Location: /wwe/data/matches/list");
        exit;
    } catch (Exception $e) {
        $_SESSION["mesgs"]['errors'][] = "Erreur lors de la mise à jour: " . $e->getMessage();
    }
}
?>