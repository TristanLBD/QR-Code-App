<?php
    class Text extends QRCode {
        protected $text;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}


        public function getText() {return $this->text;}

        public function setText($text) {
            if(strlen($text) > 2048) { throw new Exception("Texte trop long."); }
            $this->text = $text;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO text VALUES (:idQR, :text)',[':idQR' => $this->getId(),':text' => $this->getText()]);
        }
    }
?>