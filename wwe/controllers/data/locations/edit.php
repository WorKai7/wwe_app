<?php
include __DIR__.'/../../../class/location.class.php';

$title = "Modifier un lieu";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $locationId = (int)$_GET['id'];
    $location = new Location($db);
    
    try {
        $location->fetch($locationId);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            
            $location->name = $name;
            $location->update();
            
            $_SESSION["mesgs"]["confirm"][] = "Lieu modifié avec succès";
            session_write_close();
            header("Location:/wwe/data/locations/list");
            exit();
        }
        
    } catch (Exception $e) {
        $_SESSION["mesgs"]["errors"][] = "Erreur : " . $e->getMessage();
    }
}

?>