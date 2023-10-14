<?php
    include_once("./classes/DB.class.php");
    $DB = new DB();


    if (!isset($_SESSION)) { session_start(); }
    
    //! Pour le chargement automatique des classes
    function chargerClasse($classname) {
        if (strpos($classname, "Manager")) {
            require('classes/managers/' . $classname . '.class.php');
        } else if (strpos($classname, "Helper")) {
            require('classes/helpers/' . $classname . '.class.php');
        } else {
            require('classes/classes/' . $classname . '.class.php');
        }
    }
    spl_autoload_register('chargerClasse');
    
    include_once("./includes/functions.inc.php");
    
    checkRememberMe($DB);
?>