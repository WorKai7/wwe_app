<?php
include __DIR__.'/../../../class/wrestling_match.class.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $wrestlingMatchId = (int)$_GET['id'];
    
    try {
        $wrestlingMatch = new WrestlingMatch($db);
        $wrestlingMatch->fetch($wrestlingMatchId);
        $wrestlingMatch->delete();
        $_SESSION['mesgs']['confirm'][] = "Match supprimé avec succès!";
        header("Location:/wwe/data/matches/list");
        session_write_close();
        exit();
        
    } catch (Exception $e) {
        $_SESSION['mesgs']['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
        header("Location:/wwe/data/matches/list");
        session_write_close();
        exit();
    }
}

?>