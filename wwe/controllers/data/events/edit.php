<?php
include __DIR__.'/../../../class/event.class.php';

$title = "Modifier un évènement";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = (int)$_GET['id'];
    $event = new Event($db);
    
    try {
        $event->fetch($eventId);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            
            $event->name = $name;
            $event->update();
            
            $_SESSION["mesgs"]["confirm"][] = "Évènement modifié avec succès";
            session_write_close();
            header("Location:/wwe/data/events/list");
            exit();
        }
        
    } catch (Exception $e) {
        $_SESSION["mesgs"]["errors"][] = "Erreur : " . $e->getMessage();
    }
}

?>