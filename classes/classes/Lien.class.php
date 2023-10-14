<?php
    class Lien extends QRCode {
        protected $link;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}
        
        public function getLink() {return $this->link;}
        public function setLink($link) {
            if(strlen($link) > 2048) { throw new Exception("Lien trop long."); }
            $this->link = $link;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO lien VALUES (:idQR, :lien)',[':idQR' => $this->getId(),':lien' => $this->getLink()]);
        }
    }
?>