<?php
include __DIR__.'/../../../class/wrestler.class.php';

$title = "Modifier un catcheur";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $wrestlerId = (int)$_GET['id'];
    $wrestler = new Wrestler($db);
    
    try {
        $wrestler->fetch($wrestlerId);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            
            $wrestler->name = $name;
            $wrestler->update();
            
            $_SESSION["mesgs"]["confirm"][] = "Catcheur modifié avec succès";
            session_write_close();
            header("Location:/wwe/data/wrestlers/list");
            exit();
        }
        
    } catch (Exception $e) {
        $_SESSION["mesgs"]["errors"][] = "Erreur : " . $e->getMessage();
    }
}

?>