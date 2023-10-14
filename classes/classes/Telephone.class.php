<?php
    class Telephone extends QRCode {
        protected $telephone;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}
                
        public function getTelephone() {return $this->telephone;}
        public function setTelephone($telephone) {
            if(strlen($telephone) > 15) { throw new Exception("Numéro trop long."); }
            $this->telephone = $telephone;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO telephone VALUES (:idQR, :telephone)',[':idQR' => $this->getId(),':telephone' => $this->getTelephone()]);
        }
    }
?>