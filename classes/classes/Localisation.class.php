<?php
    class Localisation extends QRCode {
        protected $longitude;
        protected $latitude;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}
        
        public function getLatitude() {return $this->latitude;}
        public function setLatitude($latitude) {
            if(strlen($latitude) > 15) { throw new Exception("Latitude trop long."); }
            $this->latitude = $latitude;
        }

        public function getLongitude() {return $this->longitude;}
        public function setLongitude($longitude) {
            if(strlen($longitude) > 15) { throw new Exception("Longitude trop long."); }
            $this->longitude = $longitude;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO localisation VALUES (:idQR, :latitude, :longitude)',
            [':idQR' => $this->getId(),':latitude' => $this->getLatitude(),':longitude' => $this->getLongitude()]);
        }
    }
?>