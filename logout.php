<?php 
    include_once("./includes/connect.inc.php");

    //! Pour détruire le cookie
    if(isset($_COOKIE['user_r'])) {
        $datas = $_COOKIE['user_r'];
        $credentials = explode('___',$datas);

        if(!empty(trim($datas)) && count($credentials) == 2) {
            $identifier = $credentials[0];
            $user = new Utilisateur(['db' => $DB]);
            $user->updateRememberIdentifier(null,null,$_SESSION['id']);
        }
        
        //! Supprimer le cookie grace a une date antérieure
        setcookie("user_r", "", time() - 3600);

        //! Supprimer côté serveur si nécessaire
        unset($_COOKIE["user_r"]);
    }
    
    session_destroy();
    header('Location: index.php'); die();
?>