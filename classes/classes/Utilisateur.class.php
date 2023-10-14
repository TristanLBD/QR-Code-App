<?php
    class Utilisateur {
        private $_DB;
        private $_idUtilisateur;
        private $_pseudo;
        private $_mail;
        private $_password;
        private $_rememberid;
        private $_remembertoken;

        private $_errors = array();
        public function getErrors() { return $this->_errors; }
        public function setErrors(Array $errors) {
            foreach ($errors as $key => $value) {
                $this->_errors[$key] = $value;
            }
        }



        public function __construct(array $donnees) {$this->hydrate($donnees);}

        public function hydrate(array $donnees) {
            foreach ($donnees as $key => $value) {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
        //! Getter
        public function getIdUtilisateur() { return $this->_idUtilisateur; }
        public function getPseudo() { return $this->_pseudo; }
        public function getMail() { return $this->_mail; }
        public function getPassword() { return $this->_password; }
        public function getRememberIdentifier() { return $this->_rememberid; }
        public function getRememberToken() { return $this->_remembertoken; }

        //! Setters
        public function setIdUtilisateur(Int $id) {
            $id = (int) $id;
            if ($id > 0) {
                $this->_idUtilisateur = $id;
            }
        }

        public function setPseudo($pseudo) {
            if(is_string($pseudo) && $pseudo != "" && strlen($pseudo) >= 3 && strlen($pseudo) <= 50) {
                $this->_pseudo = $pseudo;
            }
        }

        public function setMail($mail) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL) && strlen($mail) <= 120 && strlen($mail) >= 5) {
                $this->_mail = $mail;
            }
        }

        public function setPassword($password) {
            $this->_password = $password;
        }

        public function setRememberIdentifier($id) {
            $this->_rememberid = $id;
        }

        public function setRememberToken($id) {
            $this->_remembertoken = $id;
        }
        
        public function setDb(DB $DB) { $this->_DB = $DB; }

        //! Functions
        public function deleteUtilisateur() {
            $this->_DB->request('DELETE FROM qr WHERE idQR = :idQR', [':idQR' => $this->getIdUtilisateur()]);
        }

        public function addToDatabase() {
            $this->_DB->request('INSERT into utilisateurs(pseudo,password,mail,RememberIdentifier,RememberToken) VALUES(:pseudo,:password,:mail,:RememberIdentifier,:RememberToken)',[':pseudo' => $this->getPseudo(),':password' => $this->getPassword(),':mail' => $this->getMail(),':RememberIdentifier' => $this->getRememberIdentifier(),':RememberToken' => $this->getRememberToken()]);
        }

        public function delete(Int $ID) {
            $this->_DB->request('DELETE FROM utilisateurs WHERE idUtilisateur = :idUtilisateur',[':idUtilisateur' => $ID]);
        }

        public function exists($userEmail) {
            return $this->_DB->fetch('SELECT idUtilisateur, pseudo, password FROM utilisateurs WHERE mail = :mail;', [":mail" => $userEmail]);
        }

        public function getByRememberIdentifier($identifier) {
            return $this->_DB->fetch('SELECT idUtilisateur, pseudo, RememberIdentifier, RememberToken FROM utilisateurs WHERE RememberIdentifier = :identifier;', [":identifier" => $identifier]);
        }

        public function resetRememberIdentifier($RememberIdentifier) {
            $this->_DB->request('UPDATE utilisateurs SET RememberIdentifier = :id, RememberToken = :token WHERE RememberIdentifier = :RememberId;', [":id" => null,":token" => null,":RememberId" => $RememberIdentifier]);
        }

        public function updateRememberIdentifier($RememberIdentifier, $RememberToken, $idUtilisateur) {
            $this->_DB->request('UPDATE utilisateurs SET RememberIdentifier = :id, RememberToken = :token WHERE idUtilisateur = :idUtilisateur;', [":id" => $RememberIdentifier,":token" => $RememberToken,":idUtilisateur" => $idUtilisateur]);
        }
    }
?>