<?php
include __DIR__.'/../../../class/wrestler.class.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $wrestlerId = (int)$_GET['id'];
    
    try {
        $wrestler = new Wrestler($db);
        $wrestler->fetch($wrestlerId);
        $wrestler->delete();
        $_SESSION['mesgs']['confirm'][] = "Catcheur supprimé avec succès!";
        header("Location:/wwe/data/wrestlers/list");
        session_write_close();
        exit();
        
    } catch (Exception $e) {
        $_SESSION['mesgs']['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
        header("Location:/wwe/data/wrestlers/list");
        session_write_close();
        exit();
    }
}

?>