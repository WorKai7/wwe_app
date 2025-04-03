<?php
include __DIR__.'/../../../class/wrestling_match.class.php';
include __DIR__.'/../../../class/wrestler.class.php';

$title = "Ajouter un match";

error_reporting(0);

try {
    $wrestlers = Wrestler::fetchAllSingle($db);
    
    // Récupérer tous les types de match (requête directe) Désolé monsieur j'ai plus le temps
    $matchTypesQuery = $db->query("SELECT id, name FROM match_types ORDER BY name");
    $matchTypes = $matchTypesQuery->fetchAll(PDO::FETCH_OBJ);
    
} catch (Exception $e) {
    $_SESSION["mesgs"]["errors"][] = "Erreur lors du chargement des données : " . $e->getMessage();
}

if (isset($_POST['confirm_envoyer'])) {
    try {

        // Vérification que le vainqueur et le perdant sont différents
        if ($_POST['winner_id'] !== $_POST['loser_id']) {

            // Validation du format de durée (MM:SS)
            if (preg_match('/^\d{1,2}:\d{2}$/', $_POST['duration'])) {

                // Création du match
                $match = new WrestlingMatch($db);
                $match->winner_id = $_POST['winner_id'];
                $match->loser_id = $_POST['loser_id'];
                $match->match_type_id = $_POST['match_type_id'];
                $match->win_type = $_POST['win_type'];
                $match->duration = $_POST['duration'];
                
                $match->create();
                
                $_SESSION["mesgs"]['confirm'][] = "Match ajouté avec succès!";
                header("Location: /wwe/data/matches/list");
                session_write_close();
            } else {
                $_SESSION["mesgs"]["errors"][] = "Erreur: Format de durée invalide";
            }
        } else {
            $_SESSION["mesgs"]["errors"][] = "Erreur: Le gagnant et le perdant ne peuvent pas être identiques";
        }
    } catch (Exception $e) {
        $_SESSION["mesgs"]['errors'][] = "Erreur lors de l'ajout du match: " . $e->getMessage();
    }
}