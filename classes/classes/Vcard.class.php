<?php
    class Vcard extends QRCode {
        protected $nom;
        protected $prenom;
        protected $email;
        protected $site;
        protected $entreprise;
        protected $job;
        protected $rue;
        protected $ville;
        protected $postal;
        protected $region;
        protected $pays;
        protected $note;
        protected $telephone;
    
        public function __construct(array $donnees) {$this->hydrate($donnees);}

        public function getNom() {return $this->nom;}
        public function setNom($nom) {
            if(strlen($nom) > 75) { throw new Exception("Nom trop long."); }
            $this->nom = $nom;
        }
        public function getPrenom() {return $this->prenom;}
        public function setPrenom($prenom) {
            if(strlen($prenom) > 75) { throw new Exception("Prénom trop long."); }
            $this->prenom = $prenom;
        }

        public function getEmail() {return $this->email;}
        public function setEmail($email) {
            if(strlen($email) > 320) { throw new Exception("Email trop long."); }
            $this->email = $email;
        }
        public function getSite() {return $this->site;}
        public function setSite($site) {
            if(strlen($site) > 2048) { throw new Exception("Lien trop long."); }
            $this->site = $site;
        }

        public function getEntreprise() {return $this->entreprise;}
        public function setEntreprise($entreprise) {
            if(strlen($entreprise) > 200) { throw new Exception("Nom d'entreprise trop long."); }
            $this->entreprise = $entreprise;
        }
        public function getJob() {return $this->job;}
        public function setJob($job) {
            if(strlen($job) > 200) { throw new Exception("Nom trop long."); }
            $this->job = $job;
        }

        public function getRue() {return $this->rue;}
        public function setRue($rue) {
            if(strlen($rue) > 250) { throw new Exception("Nom de rue trop long."); }
            $this->rue = $rue;
        }
        public function getTelephone() {return $this->telephone;}
        public function setTelephone($telephone) {
            if(strlen($telephone) > 15) { throw new Exception("Numéro trop long."); }
            $this->telephone = $telephone;
        }

        public function getVille() {return $this->ville;}
        public function setVille($ville) {
            if(strlen($ville) > 250) { throw new Exception("Nom de ville trop long."); }
            $this->ville = $ville;
        }
        public function getPostal() {return $this->postal;}
        public function setPostal($postal) {
            if(strlen($postal) > 10) { throw new Exception("Code postal trop long."); }
            $this->postal = $postal;
        }

        public function getRegion() {return $this->region;}
        public function setRegion($region) {
            if(strlen($region) > 10) { throw new Exception("Nom de region trop long."); }
            $this->region = $region;
        }
        public function getPays() {return $this->pays;}
        public function setPays($pays) {
            if(strlen($pays) > 50) { throw new Exception("Nom de pays trop long."); }
            $this->pays = $pays;
        }

        public function getNote() {return $this->note;}
        public function setNote($note) {
            if(strlen($note) > 512) { throw new Exception("Note trop longue."); }
            $this->note = $note;
        }

        public function addToDatabase() {
            parent::addToDb();
            $this->setId($this->DB->getLastInsertedID());
            $this->DB->request('INSERT INTO vcard VALUES (:idQR,:nom,:prenom,:email,:site,:telephone,:entreprise,:job,:rue,:ville,:postal,:region,:pays,:note)',
            [':idQR' => $this->getId(),':nom' => $this->getNom(),':prenom' => $this->getPrenom(),':email' => $this->getEmail(),':telephone' => $this->getTelephone(),':site' => $this->getSite(),':entreprise' => $this->getEntreprise(),':job' => $this->getJob(),':rue' => $this->getRue(),':ville' => $this->getVille(),':postal' => $this->getPostal(),':region' => $this->getRegion(),':pays' => $this->getPays(),':note' => $this->getNote()]);
        }


    }
?>