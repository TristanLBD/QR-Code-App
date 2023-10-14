<?php
    include_once("./includes/connect.inc.php");
    if(!isset($_SESSION['id'])) { $response['success'] = "error"; $response['message'] = "Veuillez vous connecter."; echo json_encode($response); exit; }
    
    function checkColor($color, float $defaultColor = 0) :float {
        if(is_numeric($color) && $color >= 0 && $color <= 255) { return $color; }
        if(is_numeric($color) && $color < 0) { return 0; }
        if(is_numeric($color) && $color > 255) { return 255; }
        return $defaultColor;
    }

    function checkOpacity($opacity) :float {
        if(is_numeric($opacity) && $opacity >= 0 && $opacity <= 1) { $result = (1 - $opacity) * 127; return $result; }
        if(is_numeric($opacity) && $opacity < 0) { $result = 0; return $result; }
        if(is_numeric($opacity) && $opacity > 1) { $result = 1; return $result; }
        $result = 0;
        return $result;
    }


    //! Couleur du code
    if(isset($_POST['QR-foreground'])) {
        $foregroundColors = json_decode($_POST['QR-foreground'], true);
        if(!is_array($foregroundColors) || !count($foregroundColors) == 3) {
            $foregroundColors = array(0,0,0);
        }
    }

    // ! Couleur du fond
    if(isset($_POST['QR-background'])) {
        $backgroundColors = json_decode($_POST['QR-background'], true);
        if(!is_array($backgroundColors) || !count($backgroundColors) == 4) {
            $backgroundColors = array(255,255,255,127);
        }
    }

    //! Couleur du label
    if(isset($_POST['QR-label-color'])) {
        $labelColors = json_decode($_POST['QR-label-color'], true);
        if(!is_array($labelColors) || !count($labelColors) == 3) {
            $labelColors = array(0,0,0);
        }
    }

    //! Taille du QR
    if(isset($_POST['QR-size']) && is_numeric($_POST['QR-size']) && $_POST['QR-size'] >= 50) {$QRSize = $_POST['QR-size'];} 
    else {$QRSize = 300;}

    //! Marge du QR
    if(isset($_POST['QR-margin']) && is_numeric($_POST['QR-margin']) && $_POST['QR-margin'] >= 0) {$QRMargin = $_POST['QR-margin'];} 
    else { $QRMargin = 20; }

    //! Label 
    $label = '';
    if(isset($_POST['QR-label']) && strlen(trim($_POST['QR-label'])) > 0) {
        $label = $_POST['QR-label'];
    }

    //! Label position
    $labelPosition = 'center';
    if(isset($_POST['QR-label-position']) && strlen(trim($_POST['QR-label-position'])) > 0) {
        $labelPoseArray = ['left','right','center'];
        if(in_array($_POST['QR-label-position'],$labelPoseArray)) { $labelPosition = $_POST['QR-label-position']; }
    }

    // //! Error level
    $errorLevel = "medium";
    if(isset($_POST['QR-error'])) {
        $errorLevelArray = ['low','medium','hight'];
        if(in_array($_POST['QR-error'],$errorLevelArray)) { $errorLevel = $_POST['QR-error']; }
    }

    try {
        //! Liens
        if(isset($_POST['input-value']) && $_POST['input-type'] == "lien" && strlen($_POST['input-value']) > 0) {
            $qrcode = new Lien(['db' => $DB, 'link' => $_POST['input-value'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }

        //! Texte
        if(isset($_POST['input-value']) && $_POST['input-type'] == "text" && strlen($_POST['input-value']) > 0) {
            $qrcode = new Text(['db' => $DB, 'text' => $_POST['input-value'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }
        //! Mail
        if(isset($_POST['input-value']) && $_POST['input-type'] == "mail" && strlen($_POST['input-value']) > 0) {
            $qrcode = new Mail(['db' => $DB, 'mail' => $_POST['input-value'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }

        //! Téléphone
        if(isset($_POST['input-value']) && $_POST['input-type'] == "telephone" && strlen($_POST['input-value']) > 0) {
            $qrcode = new Telephone(['db' => $DB, 'telephone' => $_POST['input-value'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }
        
        //! SMS
        if(isset($_POST['input-first-value'],$_POST['input-second-value']) && $_POST['input-type'] == 'sms') {
            $qrcode = new Sms(['db' => $DB, 'sms' => $_POST['input-second-value'], 'numero' => $_POST['input-first-value'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }

        //! Localisation
        if(isset($_POST['input-first-value'],$_POST['input-second-value']) && $_POST['input-type'] == 'localisation') {
            $qrcode = new Localisation(['db' => $DB, 'latitude' => $_POST['input-first-value'], 'longitude' => $_POST['input-second-value'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }
    
        //! Wifi 
        if(isset($_POST['QR-wifi'],$_POST['QR-wifi-password'],$_POST['QR-hidden'],$_POST['QR-encryption']) && $_POST['input-type'] == 'wifi') {
            $qrcode = new Wifi(['db' => $DB, 'wifi' => $_POST['QR-wifi'], 'password' => $_POST['QR-wifi-password'], 'encryption' => $_POST['QR-encryption'], 'visible' => $_POST['QR-hidden'], 'id' => $_SESSION['id'], 'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }

        //! VCard
        if(isset($_POST['input-type']) && $_POST['input-type'] == 'vcard') {
            $qrcode = new Vcard(['db' => $DB, 
            'nom' => $_POST['QR-name'], 
            'prenom' => $_POST['QR-firstname'],
            'email' => $_POST['QR-mail'],
            'site' => $_POST['QR-site'],
            'telephone' => $_POST['QR-phone'],
            'entreprise' => $_POST['QR-company'],
            'job' => $_POST['QR-job'],
            'rue' => $_POST['QR-address'],
            'ville' => $_POST['QR-city'],
            'postal' => $_POST['QR-zip'],
            'region' => $_POST['QR-region'],
            'pays' => $_POST['QR-country'],
            'note' => $_POST['QR-note'],
            'id' => $_SESSION['id'],
            'margin' => $QRMargin,'qrsize' => $QRSize,'label' => $label,'labelposition' => $labelPosition,'errorlevel' => $errorLevel,'backgroundcolor' => checkColor($backgroundColors[0],255).'.'.checkColor($backgroundColors[1],255).'.'.checkColor($backgroundColors[2],255).'.'.checkOpacity($backgroundColors[3]),'foregroundcolor' => checkColor($foregroundColors[0]).'.'.checkColor($foregroundColors[1]).'.'.checkColor($foregroundColors[2]),'labelcolor' => checkColor($labelColors[0]).'.'.checkColor($labelColors[1]).'.'.checkColor($labelColors[2])]);
            $qrcode->addToDatabase();
            returnJsonSuccess($qrcode);
        }
    } catch (\Throwable $e) {
        $response = array();
        $response['success'] = "error";
        $response['message'] = $e->getMessage();
        echo json_encode($response);
        exit;
    }

    function returnJsonSuccess($qrcode) {
        $response = array();
        $response['success'] = "success";
        $response['message'] = "QR code sauvegardé avec succes !";
        $response['value'] = $qrcode->getId();
        // $response['value'] = $DB->getLastInsertedID();
        echo json_encode($response);
        exit;    
    }
?>
