<?php
    $QrCodeType = "sms";
    $QrText = '';
    $QRmessage = 'SMS';
    if(isset($_POST['input-type'])) {
        $availableQrCodeType = ["localisation","sms"];
        if(in_array(htmlspecialchars($_POST['input-type']),$availableQrCodeType)) { $QrCodeType = htmlspecialchars($_POST['input-type']); }
    }

    if(!isset($_POST['input-first-value'],$_POST['input-second-value'])) { 
        header('Content-Type: application/json');
        $response['success'] = "error";
        $response['message'] = "Une erreur est survenue.";
        $response['value'] = "placeholder.png";
        echo json_encode($response);
        die;
    }
    
    if($QrCodeType == "localisation") { $QRmessage = 'Localisation'; $QrText = "geo:".$_POST['input-first-value'].",".$_POST['input-second-value']; }
    if($QrCodeType == "sms") { $QrText = "SMSTO:".$_POST['input-first-value'].":".$_POST['input-second-value']; }

    require "vendor/autoload.php";
    session_start();
    $imageID = $_POST['QR-id'];
    
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;
    use Endroid\QrCode\Color\Color;
    use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
    use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
    use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
    use Endroid\QrCode\Label\Label;
    use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
    use Endroid\QrCode\Label\Alignment\LabelAlignmentRight;
    use Endroid\QrCode\Label\Alignment\LabelAlignmentLeft;
    use Endroid\QrCode\Logo\Logo;
    
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

    //! Couleur du fond
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

$qr_code = QrCode::create($QrText)
    ->setSize($QRSize)
    ->setMargin($QRMargin)
    ->setForegroundColor(new Color(checkColor($foregroundColors[0]),checkColor($foregroundColors[1]),checkColor($foregroundColors[2])))
    ->setBackgroundColor(new Color(checkColor($backgroundColors[0],255),checkColor($backgroundColors[1],255),checkColor($backgroundColors[2],255),checkOpacity($backgroundColors[3]))); //! 127 = transparent  1 / (127 * 3) 

    //! Label 
    $label = null;
    if(isset($_POST['QR-label']) && strlen(trim($_POST['QR-label'])) > 0) {
        $label = label::create($_POST['QR-label'])->setTextColor(new Color(checkColor($labelColors[0]),checkColor($labelColors[1]),checkColor($labelColors[2])));

        if(isset($_POST['QR-label-position']) && $_POST['QR-label-position'] == "left") {$label->setAlignment(new LabelAlignmentLeft); } 
        else if (isset($_POST['QR-label-position']) && $_POST['QR-label-position'] == "right") {$label->setAlignment(new LabelAlignmentRight); } 
        else {$label->setAlignment(new LabelAlignmentCenter); }
    }

    //! Error level 
    if(isset($_POST['QR-error'])) {
        if($_POST['QR-error'] == "low") { $qr_code->setErrorCorrectionLevel(new ErrorCorrectionLevelLow); }
        if($_POST['QR-error'] == "medium") { $qr_code->setErrorCorrectionLevel(new ErrorCorrectionLevelMedium); }
        if($_POST['QR-error'] == "hight") { $qr_code->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh); }
    } else {
        $qr_code->setErrorCorrectionLevel(new ErrorCorrectionLevelLow);
    }

    //! Logo
    $logo = null;
    //! Vérifiez si les fichiers ont été correctement téléchargés
    if (isset($_FILES['QR-logo']) && $_FILES['QR-logo']['error'] === UPLOAD_ERR_OK) {
        $image = imagecreatefromstring(file_get_contents($_FILES['QR-logo']['tmp_name']));

        if($image) {
            $nouveauChemin = './assets/QRLogos/' . $imageID . '.png';
            if(imagepng($image, $nouveauChemin)) {
                imagedestroy($image);
                $logo = Logo::create('./assets/QRLogos/' . $imageID . '.png');

                if(isset($_POST['QR-logo-size']) && is_numeric($_POST['QR-logo-size']) && $_POST['QR-logo-size'] >= 0 && $_POST['QR-logo-size'] <= 1) {$logoSize = max(($_POST['QR-logo-size'] * $QRSize/3),($QRSize/9));}
                else { $logoSize = (0.5 * $QRSize/3); }
                $logo->setResizeToWidth($logoSize);
            }
        }
    }

    $writer = new PngWriter;
    $result = $writer->write($qr_code, $logo, $label);
    
    $result->saveToFile("./assets/QRImages/".$imageID.".png");
    header('Content-Type: application/json');
    $response['success'] = "success";
    $response['message'] = $QRmessage." correctement générée.";
    $response['value'] = $imageID;
    echo json_encode($response);
    exit;
?>