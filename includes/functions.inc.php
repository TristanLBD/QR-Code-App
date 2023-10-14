<?php
    function generateRandomString(Int $length): string {
        $string = "";
        $chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9];
        for ($i=0; $i < $length; $i++) {
            $string .= $chars[array_rand($chars,1)];
        }
        return $string;
    }

    function passwordCheck($pass) :bool {
        $nb_points = 10;
        $nb_caractere = strlen($pass);
        $points_nbcarac = 0;
        $points_complexite = 0;
        //! Vérification de la longueur du mot de passe
        if($nb_caractere >= 12) { $points_nbcarac = 1; };        
        //! Vérification des lettres minuscules
        if(preg_match("/[a-z]/", $pass)) {  $points_complexite = $points_complexite + 1; }
        //! Vérification des lettres majuscules
        if(preg_match("/[A-Z]/", $pass)) {  $points_complexite = $points_complexite + 2; } 
        //! Vérification des chiffres
        if(preg_match("/[0-9]/", $pass)) {  $points_complexite = $points_complexite + 3; }
        //! Vérification des caractères spéciaux
        if(preg_match("/\W/", $pass)) {  $points_complexite = $points_complexite + 4; }

        $resultat = $points_nbcarac * $points_complexite;
        return($nb_points == $resultat);
    }

    function checkRememberMe($DB) {
        //! https://www.youtube.com/watch?v=XbQyOiEFDj0&list=PLCv1L2TXebNR4xnYAwDeRBdVpAPO6F8rO&index=476
        //! https://youtu.be/XbQyOiEFDj0?list=PLCv1L2TXebNR4xnYAwDeRBdVpAPO6F8rO&t=1231
        if(isset($_COOKIE['user_r']) && !isset($_SESSION['id'])) {
            $datas = $_COOKIE['user_r'];
            $credentials = explode('___',$datas);

            if(empty(trim($datas)) || count($credentials) !== 2) { header('Location: index.php'); die();} 
            else {
                $identifier = $credentials[0];
                $token = $credentials[1];
                $utilisateur = new Utilisateur(['db'=> $DB]);
                $user = $utilisateur->getByRememberIdentifier($identifier);

                if($user) {
                    if(password_verify($token, $user['RememberToken'])) {
                        $_SESSION['pseudo'] = $user['pseudo'];
                        $_SESSION['id'] = $user['idUtilisateur'];
                    } else {
                        $utilisateur->updateRememberIdentifier(null,null,$user['idUtilisateur']);
                        setcookie("user_r", "", time() - 3600);
                        unset($_COOKIE["user_r"]);
                    }
                }
            }
        }
    }
?>