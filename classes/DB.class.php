<?php 
    class DB {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $database = 'qrcodeapp';
        private $db;

        /**
         * Undocumented function
         *
         * @param String|null $host
         * @param String|null $username
         * @param String|null $password
         * @param String|null $database
         */
        public function __construct(String $host = null,String $username = null,String $password = null,String $database = null) {
            if($host != null) {
                $this->host = $host;
                $this->username = $username;
                $this->password = $password;
                $this->database = $database;
            }

            try {
                $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->username,$this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            } catch(PDOException $e) {
                header('Location: error.php');
                die();
            }
        }

        public function fetch($sql, $data = array()) {
            $req = $this->db->prepare($sql);
            $req->execute($data);
            // return $req->fetch(PDO::FETCH_OBJ);
            return $req->fetch(PDO::FETCH_ASSOC);
        }

        public function fetchAll($sql, $data = array()) {
            $req = $this->db->prepare($sql);
            $req->execute($data);
            // return $req->fetchAll(PDO::FETCH_OBJ);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        public function request($sql, $data = array()) {
            $req = $this->db->prepare($sql);
            $success = $req->execute($data);
            // return $success;

            if ($success) {
                // Récupérer le dernier ID inséré
                return $this->db->lastInsertId();
            } else {
                // Gérer les erreurs ou retourner false en cas d'échec de la requête
                return false;
            }
        }

        public function getLastInsertedID() {
            return $this->db->lastInsertId();
        }

    }
?>