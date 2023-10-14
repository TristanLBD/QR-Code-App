<?php
    class Wifi extends QRCode {
        protected $wifi;
        protected $password;
        protected $encryption;
        protected $visible;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}
                
        public function getWifi() {return $this->wifi;}
        public function setWifi($wifi) {$this->wifi = $wifi;}

        public function getPassword() {return $this->password;}
        public function setPassword($password) {$this->password = $password;}

        public function getEncryption() {return $this->encryption;}
        public function setEncryption($encryption) {$this->encryption = $encryption;}

        public function getVisible() {return $this->visible;}
        public function setVisible($visible) {$this->visible = $visible;}

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO wifi VALUES (:idQR, :wifi,:pass,:encryption,:visible)',[':idQR' => $this->getId(),':wifi' => $this->getWifi(),':pass' => $this->getPassword(),':encryption' => $this->getEncryption(),':visible' => $this->getVisible()]);
        }
    }
?>