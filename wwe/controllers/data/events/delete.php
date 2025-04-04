<?php
include __DIR__.'/../../../class/event.class.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = (int)$_GET['id'];
    
    try {
        $event = new Event($db);
        $event->fetch($eventId);
        $event->delete();
        $_SESSION['mesgs']['confirm'][] = "Évènement supprimé avec succès!";
        header("Location:/wwe/data/events/list");
        session_write_close();
        exit();
        
    } catch (Exception $e) {
        $_SESSION['mesgs']['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
        header("Location:/wwe/data/events/list");
        session_write_close();
        exit();
    }
}

?>