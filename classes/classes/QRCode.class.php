<?php
    abstract class QRCode {
        protected $id;
        protected $DB;
        protected $margin;
        protected $qrsize;
        protected $label;
        protected $labelposition;
        protected $errorlevel;
        protected $backgroundcolor;
        protected $foregroundcolor;
        protected $labelcolor;

        abstract public function addToDatabase();

        public function __construct(array $donnees) {$this->hydrate($donnees);}
        public function hydrate(array $donnees) {
            foreach ($donnees as $key => $value) {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }

        public function setId($id) {$this->id = $id;}
        public function getId() { return $this->id; }

        public function setMargin($margin) {$this->margin = $margin;}
        public function getMargin() { return $this->margin; }

        public function setQrsize($qrsize) {$this->qrsize = $qrsize;}
        public function getQrsize() { return $this->qrsize; }

        public function setLabel($label) {$this->label = $label;}
        public function getLabel() { return $this->label; }

        public function setLabelposition($labelposition) {$this->labelposition = $labelposition;}
        public function getLabelposition() { return $this->labelposition; }

        public function setErrorlevel($errorlevel) {$this->errorlevel = $errorlevel;}
        public function getErrorlevel() { return $this->errorlevel; }

        public function setBackgroundcolor($backgroundcolor) {$this->backgroundcolor = $backgroundcolor;}
        public function getBackgroundcolor() { return $this->backgroundcolor; }

        public function setForegroundcolor($foregroundcolor) {$this->foregroundcolor = $foregroundcolor;}
        public function getForegroundcolor() { return $this->foregroundcolor; }

        public function setLabelcolor($labelcolor) {$this->labelcolor = $labelcolor;}
        public function getLabelcolor() { return $this->labelcolor; }

        public function deleteQR() {
            // $DB->request('DELETE FROM qr WHERE idQR = :idQR', [':idQR' => 57]);
            $this->DB->request('DELETE FROM qr WHERE idQR = :idQR', [':idQR' => $this->getId()]);
        }

        protected function addToDb() {
            $this->DB->request('INSERT INTO qr (idutilisateur,margin,size,label,labelposition,error,backgroundcolor,foregroundcolor,labelcolor) VALUES (:idUser,:margin,:qrsize,:label,:labelposition,:error,:backgroundcolor,:foregroundcolor,:labelcolor)',
            [':idUser' => $this->getId(),':margin' => $this->getMargin(),':qrsize' => $this->getQrsize(),':label' => $this->getLabel(),':labelposition' => $this->getLabelposition(),':error' => $this->getErrorlevel(),':backgroundcolor' => $this->getBackgroundcolor(),':foregroundcolor' => $this->getForegroundcolor(),':labelcolor' => $this->getLabelcolor()]);
        }

        public function getQrCode(String $QRType,Int $QRId, Int $IdUser) {
            $availableTypes = ['lien','localisation','mail','sms','telephone','text','wifi','vcard'];
            if(in_array($QRType,$availableTypes)) {
                $qrCode = $this->DB->fetch("SELECT qr.*,$QRType.* from qr,utilisateurs, $QRType WHERE qr.idUtilisateur = utilisateurs.idUtilisateur AND utilisateurs.idUtilisateur = :idUtilisateur AND qr.idQR = $QRType.idQR AND qr.idQR = :idQR",[':idQR' => $QRId,':idUtilisateur'=> $IdUser]);
                return $qrCode;
            }
            return false;
        }

        public function setDb(DB $DB) {
            $this->DB = $DB;
        }
    }
?>