<?php
    class Sms extends QRCode {
        protected $sms;
        protected $numero;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}
        
        public function getSms() {return $this->sms;}
        public function setSms($sms) {
            if(strlen($sms) > 1000) { throw new Exception("Numéro trop long."); }
            $this->sms = $sms;
        }

        public function getNumero() {return $this->numero;}
        public function setNumero($numero) {
            if(strlen($numero) > 15) { throw new Exception("Numéro trop long."); }
            $this->numero = $numero;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO sms VALUES (:idQR, :sms, :numero)',
            [':idQR' => $this->getId(),':sms' => $this->getsms(),':numero' => $this->getnumero()]);
        }
    }
?>