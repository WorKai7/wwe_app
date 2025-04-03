<?php
include __DIR__.'/../../../class/wrestler.class.php';

$title = "Ajouter un catcheur";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        
        $wrestler = new Wrestler($db);
        $wrestler->name = $name;
        $wrestler->create();
        
        $_SESSION["mesgs"]["confirm"][] = "Ajout de $name avec succès";
        session_write_close();
        header("Location:/wwe/data/wrestlers/list");
    } catch (PDOException $e) {
        $_SESSION["mesgs"]["errors"][] = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>