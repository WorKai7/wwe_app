<?php
include __DIR__.'/../../../class/event.class.php';

$title = "Ajouter un évènement";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        
        $event = new Event($db);
        $event->name = $name;
        $event->create();
        
        $_SESSION["mesgs"]["confirm"][] = "Ajout de l'évènement avec succès";
        session_write_close();
        header("Location:/wwe/data/events/list");
    } catch (PDOException $e) {
        $_SESSION["mesgs"]["errors"][] = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>