<?php
include __DIR__.'/../../../class/location.class.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $locationId = (int)$_GET['id'];
    
    try {
        $location = new Location($db);
        $location->fetch($locationId);
        $location->delete();
        $_SESSION['mesgs']['confirm'][] = "Lieu supprimé avec succès!";
        header("Location:/wwe/data/locations/list");
        session_write_close();
        exit();
        
    } catch (Exception $e) {
        $_SESSION['mesgs']['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
        header("Location:/wwe/data/locations/list");
        session_write_close();
        exit();
    }
}

?>