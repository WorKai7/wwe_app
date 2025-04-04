<?php
include __DIR__.'/../../../class/location.class.php';

$title = "Ajouter un lieu";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        
        $location = new Location($db);
        $location->name = $name;
        $location->create();
        
        $_SESSION["mesgs"]["confirm"][] = "Ajout du lieu avec succès";
        session_write_close();
        header("Location:/wwe/data/locations/list");
    } catch (PDOException $e) {
        $_SESSION["mesgs"]["errors"][] = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>