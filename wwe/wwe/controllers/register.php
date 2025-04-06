<?php

if (isset($_POST) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["psw"] != $_POST["confirm_psw"]) {
        $_SESSION["mesgs"]["errors"][] = "Les mots de passe doivent être identiques";
    } else {

        $username = $_POST["uname"];
        $password = md5($_POST["psw"]);

        try {
            $db->beginTransaction();

            $checkUser = $db->prepare("SELECT id FROM users WHERE username = :username AND password = :password");
            $checkUser->bindValue(":username", $username);
            $checkUser->bindValue(":password", $password);
            $checkUser->execute();

            if (!empty($checkUser->fetch())) {
                $_SESSION["mesgs"]["errors"][] = "L'utilisateur exite déjà";
                
            } else {
                $insertUser =  $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
                $insertUser->bindValue(":username", $username);
                $insertUser->bindValue(":password", $password);
                $insertUser->execute();

                $db->commit();
                $_SESSION['mesgs']['confirm'][] = "Inscription de l'utilisateur $username avec succès";
                session_write_close();
                header("Location:/wwe/login");
            }

        } catch (PDOException $e) {
            $db->rollback();
            throw $e;
        }

    }
}

?>