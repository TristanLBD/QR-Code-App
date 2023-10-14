<?php
    include_once("./includes/connect.inc.php");
    if(isset($_SESSION['id'])) { header("Location: index.php"); die(); }
    $errors = array();

	//! Partie inscription
	if(isset($_POST['type'],$_POST['pseudo'],$_POST['email'],$_POST['pswd'],$_POST['pswdconfirm']) && $_POST['type'] == "sign-up") {   
        $userInfos = (new Utilisateur(['db' => $DB]))->exists($_POST['email']);

        //! On check si l'adresse mail existe deja avant d'effectuer le traitement
        if(!$userInfos) {
            //! Check si les deux MDP sont les memes
            if($_POST['pswd'] !== $_POST['pswdconfirm']) { $errors["signup-password"] = 'Les mots de passe sont différents'; }
            //! Check si le MDP est suffisement sécurisé
            else { if(!passwordCheck($_POST['pswd'])) { $errors["signup-password"] = "Le mot de passe n'est pas assez sécurisé."; }}
            //! Hasher le mot de passe
            $cost = ['cost' => 12];
            $password = password_hash($_POST['pswd'], PASSWORD_BCRYPT, $cost);
            
            //! Remember me
            $rememberIdentifier = null;
            $rememberToken = null;
            if(isset($_POST['signup-remember']) && $_POST['signup-remember'] == "on") {
                $rememberIdentifier = generateRandomString(128);
                $rememberToken = generateRandomString(128);
            }

            // $utilisateur = new Utilisateur(['pseudo' => $_POST['pseudo'],'mail' => $_POST['email'],'password' => $password,"RememberToken" => $rememberToken,"RememberIdentifier" => $rememberIdentifier,'db' => $DB]);
            $utilisateur = new Utilisateur(['pseudo' => $_POST['pseudo'],'mail' => $_POST['email'],'password' => $password,"RememberToken" => password_hash($rememberToken, PASSWORD_BCRYPT, $cost),"RememberIdentifier" => $rememberIdentifier,'db' => $DB]);
            
            if(empty($errors) && empty($utilisateur->getErrors())) {
                try {
                    $utilisateur->addToDatabase();

                    //! Remember me
                    setcookie("user_r", "{$rememberIdentifier}___{$rememberToken}", time() + (60 * 60 * 24 * 30));
                    $_SESSION['id'] = $DB->getLastInsertedID();
                    $_SESSION['pseudo'] = htmlspecialchars($utilisateur->getPseudo());
                    header('Location: index.php');
                    die();
                } catch (\Throwable $th) {
                    echo("Une erreur est survenue");
                }
            }
        }
	}

	//! Partie Connection
	if(isset($_POST['type'],$_POST['email'],$_POST['pswd']) && $_POST['type'] == "login") {
        $user = new Utilisateur(['db' => $DB]);
        $userInfos = $user->exists($_POST['email']);

        if($userInfos) {
            //! Si le mail est bon niveau format
            if(filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                //! Si le mot de passe est le bon
                if(password_verify($_POST['pswd'], $userInfos['password'])) {
                    //! On créer la session et on redirige

                    //! Remember me
                    $rememberIdentifier = null;
                    $rememberToken = null;
                    if(isset($_POST['login-remember']) && $_POST['login-remember'] == "on") {
                        $rememberIdentifier = generateRandomString(128);
                        $rememberToken = generateRandomString(128);
                        $cost = ['cost' => 12];
                        $user->updateRememberIdentifier($rememberIdentifier,password_hash($rememberToken, PASSWORD_BCRYPT, $cost),$userInfos['idUtilisateur']);
                        setcookie("user_r", "{$rememberIdentifier}___{$rememberToken}", time() + (60 * 60 * 24 * 30));
                    }
                    
                    $_SESSION['pseudo'] = $userInfos['pseudo'];
                    $_SESSION['id'] = $userInfos['idUtilisateur'];
                    header('Location: index.php');
                    die();
                }else{ $errors["signin-email"] = "Email ou mot de passe incorecte."; $errors["signin-password"] = "Email ou mot de passe incorecte."; }
            }else{ $errors["signin-email"] = "Email ou mot de passe incorecte."; $errors["signin-password"] = "Email ou mot de passe incorecte."; }
        }else{ $errors["signin-email"] = "Email ou mot de passe incorecte."; $errors["signin-password"] = "Email ou mot de passe incorecte."; }
	}

    include_once("./includes/header.inc.php");
?>
    <div class="row">
        <div class="col-12 text-center d-flex flex-column justify-content-center align-items-center">
            <div id="title-border"><span>Connection / Inscription</span></div>
            <div class="login-form">
                <input type="checkbox" id="chk" <?php if(isset($_GET['login'])) { echo("checked"); } ?> aria-hidden="true">

                    <div class="signup">
                        <form method="POST">
                            <label for="chk" class="title-label" aria-hidden="true">Inscription</label>
                            <input type="text" name="pseudo" placeholder="User name" required="">
                            <input type="email" name="email" placeholder="Email" required="">
                            <input type="password" name="pswd" placeholder="Password" required="">
                            <input type="password" name="pswdconfirm" placeholder="Password" required="">
                            <input style="display: none;" type="text" name="type" value="sign-up" required>
                            <label class="text-start text-light" for="signup-remember">Se souvenir de moi :</label>
                            <input class="my-0" type="checkbox" id="signup-remember" name="signup-remember">
                            <button>Sign up</button>
                        </form>
                    </div>

                    <div class="login">
                        <form method="POST">
                            <label for="chk" class="title-label" aria-hidden="true">Connexion</label>
                            <input type="email" name="email" placeholder="Email" required="">
                            <input type="password" name="pswd" placeholder="Password" required="">
                            <input style="display: none;" type="text" name="type" value="login" required>
                            <label class="text-start text-dark" for="login-remember">Se souvenir de moi :</label>
                            <input class="my-0" type="checkbox" id="login-remember" name="login-remember">
                            <button>Login</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>