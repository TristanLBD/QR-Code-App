<?php
    class Mail extends QRCode {
        protected $mail;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}

        public function getMail() {return $this->mail;}
        public function setMail($mail) {
            if(!filter_var(htmlspecialchars($mail), FILTER_VALIDATE_EMAIL)) { throw new Exception("Email invalide."); }
            if(strlen(htmlspecialchars($mail)) > 320) { throw new Exception("Email trop long."); }
            $this->mail = $mail;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO mail VALUES (:idQR, :lien)',[':idQR' => $this->getId(),':lien' => $this->getMail()]);
        }
    }
?>