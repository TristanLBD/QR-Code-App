<?php
    $actionType = "Créer";
    include_once("./includes/connect.inc.php");
    if(!isset($_SESSION['id'])) { header('Location: login.php'); die(); }

    $firstInputValue = '';
    $secondInputValue = '';
    $thirddInputValue = '';
    $fourthInputValue = '';

    if(isset($_GET["id"]) && is_numeric($_GET['id']) && $_GET["id"] > 0  && file_exists('./assets/QRImages/'.$_GET['id'].'.png')) {
        $actionType = "Modifier";

        $qrcode = new Lien(['db'=>$DB]);
        $values = $qrcode->getQrCode('wifi',$_GET["id"],$_SESSION['id']);
        if($values) {
            $firstInputValue = $values['wifi'];
            $secondInputValue = $values['password'];
            $thirddInputValue = $values['encryption'];
            $fourthInputValue = $values['visible'];
        }
    }

    include_once("./includes/header.inc.php");
?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-8">
            <div id="title-border"><span><?= $actionType ?> un WIFI</span></div>
            <form method="post" action="generateWifi.php" id="qrForm" enctype="multipart/form-data">
                
                <div class="row">
                    <div class="form-control-group col-12 mt-3">
                        <label for="QR-wifi" class="form-label fw-bolder"><i class="fa-solid fa-envelope"></i> Nom du Wifi :</label>
                        <input value="<?= $firstInputValue ?>" type="mail" class="form-control" name="QR-wifi" id="QR-wifi" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row">
                    <div class="form-control-group col-12 mt-3">
                        <label for="QR-wifi-password" class="form-label fw-bolder"><i class="fa-solid fa-envelope"></i> Mot de passe :</label>
                        <input value="<?= $secondInputValue ?>" type="mail" class="form-control" name="QR-wifi-password" id="QR-wifi-password" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="form-control-group col-12 col-md-6">
                        <label for="QR-encryption" class="form-label fw-bolder"><i class="fa-solid fa-signature"></i> Cryptage Wi-Fi :</label>
                        <select class="form-select" id="QR-encryption" name="QR-encryption" aria-label="Default select example">
                            <option <?php if($thirddInputValue == 'WEP'){ echo('selected'); } ?> value="WEP">WEP</option>
                            <option <?php if($thirddInputValue == 'WPA-WPA2'){ echo('selected'); } ?> value="WPA-WPA2">WPA/WPA2</option>
                            <option <?php if($thirddInputValue == 'nopass'){ echo('selected'); } ?> value="nopass">aucun</option>
                        </select>
                    </div>


                    <div class="form-control-group col-12 col-md-6">
                        <label for="QR-hidden" class="form-label fw-bolder"><i class="fa-solid fa-signature"></i> Wifi caché :</label>
                        <select class="form-select" id="QR-hidden" name="QR-hidden" aria-label="Default select example">
                            <option <?php if($fourthInputValue == 'non'){ echo('selected'); } ?> value="non">Non</option>
                            <option <?php if($fourthInputValue == 'oui'){ echo('selected'); } ?> value="oui">Oui</option>
                        </select>
                    </div>
                </div>

                <?php include_once('./includes/qr-options.inc.php'); ?>

                <div class="form-row text-center my-3">
                    <input type="submit" value="Ajouter" class="btn btn-primary" name="valider" />
                </div>
            </form>
        </div>

        <div class="col-12 col-md-4 d-flex flex-column justify-content-center align-items-center">
            <div class="row">
                <div class="col">
                    <p class="fs-1 fw-bolder text-decoration-underline">WIFI</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="qrDisplay" style="background-color: white !important;">
                        <img class="img-fluid border border-3 border-dark" id="qrImage" src="<?php if(isset($_GET['id']) && file_exists('./assets/QRImages/'.$_GET['id'].'.png')) { echo('./assets/QRImages/'.$_GET['id'].'.png'); } else { echo("./assets/QRImages/placeholder.png"); } ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col">
                    <a id="downloadButton" class="btn btn-primary <?php if(!isset($_GET['id']) || !file_exists('./assets/QRImages/'.$_GET['id'].'.png')) { echo('disabled'); } ?>"  href="./assets/QRImages/placeholder.png" download="V-Card QR Code" role="button"><i class="fas fa-file-download"></i> Télécharger</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function() {
                $("#qrForm").submit(function(event) {
                    event.preventDefault();
                    let backgroundColors = JSON.stringify([backgroundRed,backgroundGreen,backgroundBlue, backGroundAlpha]);
                    let foregroundColors = JSON.stringify([foregroundRed,foregroundGreen,foregroundBlue]);
                    let labelColors = JSON.stringify([labelRed,labelGreen,labelBlue,labelAlpha]);
                    var formData = new FormData($('#images')[0]);
                    formData.append('input-type', 'wifi' );
                    formData.append('QR-wifi', $('#QR-wifi').val());
                    formData.append('QR-wifi-password', $('#QR-wifi-password').val());
                    formData.append('QR-encryption', $('#QR-encryption').val());
                    formData.append('QR-hidden', $('#QR-hidden').val());
                    formData.append('QR-label', $("#QR-label").val() ? $("#QR-label").val() : '');
                    formData.append('QR-label-position', $('input[name="QR-label-position"]:checked').val());
                    formData.append('QR-margin', $('#QR-margin').val());
                    formData.append('QR-size', $('#QR-size').val());
                    formData.append('QR-error', $('#QR-error').val());
                    formData.append('QR-logo-size', $('#QR-logo-size').val());
                    formData.append('QR-background', backgroundColors);
                    formData.append('QR-foreground', foregroundColors);
                    formData.append('QR-label-color', labelColors);
                    if ($('#QR-logo')[0].files[0]) { formData.append('QR-logo', $('#QR-logo')[0].files[0]); }

                    //! Verifier si au moins un des champ est remplis
                    var requiredFields = ['QR-wifi-password','QR-wifi'];
                    var isAnyFieldFilled = requiredFields.some(function(fieldName) {
                        var value = formData.get(fieldName);
                        //! verifie qu'il existe bien dans le formData et que different de vide
                        return value !== 'undefined' && value !== undefined && value !== null && value !== "";
                    });

                    //! Si aucun champ remplis , on alerte l'utilisateur
                    if (!isAnyFieldFilled) {showToast("warning", "Au moins un des champs de contact doit être rempli.");return;}



                    $.ajax({
                        type: "POST",
                        url: "INSERT.php",
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.success == "success") {
                                formData.append('QR-id', response.value);
                                $.ajax({
                                    type: "POST",
                                    url: "generateWifi.php",
                                    data: formData,
                                    dataType: 'json',
                                    processData: false,
                                    contentType: false,
                                    success: function(secondResponse) { reloadQRCodeImage(response.value); showToast(secondResponse.success, secondResponse.message); },
                                    error: function(secondResponse) { showToast("error", "QR code non sauvegardé"); }
                                });
                            }
                            showToast(response.success, response.message);
                        },
                        error: function(response) {showToast("error", "Une erreur est survenue");}
                    });
                });
            });
        });

        function reloadQRCodeImage(imageID) {
            //! Utilisation de date now pour forcer la mise a jour du cache du navigateur
            document.getElementById("qrImage").src = './assets/QRImages/' + imageID + '.png?' + Date.now();
            document.getElementById("downloadButton").href = './assets/QRImages/' + imageID + '.png';
            document.getElementById("downloadButton").classList.remove("disabled");
        }

        //! Couleur du fond
        let backgroundRed = backgroundGreen = backgroundBlue = 255;
        let backGroundAlpha = 1;
        const pickrBackground = Pickr.create({
            el: '.color-picker-background',
            theme: 'classic',
            swatches: ['rgba(244, 67, 54, 1)','rgba(233, 30, 99, 0.95)','rgba(156, 39, 176, 0.9)','rgba(103, 58, 183, 0.85)','rgba(63, 81, 181, 0.8)','rgba(33, 150, 243, 0.75)','rgba(3, 169, 244, 0.7)','rgba(0, 188, 212, 0.7)','rgba(0, 150, 136, 0.75)','rgba(76, 175, 80, 0.8)','rgba(139, 195, 74, 0.85)','rgba(205, 220, 57, 0.9)','rgba(255, 235, 59, 0.95)','rgba(255, 193, 7, 1)'],
            components: { opacity: true, preview: true, hue: true, interaction: {hex: false,rgba: true,hsla: false,hsva: false,cmyk: false,input: false,clear: false,save: false}}
        });
        pickrBackground.on('change', (...args) => { let color = args[0].toRGBA(); backgroundRed = color[0]; backgroundGreen = color[1]; backgroundBlue = color[2], backGroundAlpha = color[3]; });

        //! Couleur du code
        let foregroundRed = foregroundGreen = foregroundBlue = 0;
        const pickrforeground = Pickr.create({
            el: '.color-picker-foreground',
            theme: 'classic',
            swatches: ['rgba(244, 67, 54, 1)','rgba(233, 30, 99, 0.95)','rgba(156, 39, 176, 0.9)','rgba(103, 58, 183, 0.85)','rgba(63, 81, 181, 0.8)','rgba(33, 150, 243, 0.75)','rgba(3, 169, 244, 0.7)','rgba(0, 188, 212, 0.7)','rgba(0, 150, 136, 0.75)','rgba(76, 175, 80, 0.8)','rgba(139, 195, 74, 0.85)','rgba(205, 220, 57, 0.9)','rgba(255, 235, 59, 0.95)','rgba(255, 193, 7, 1)'],
            components: { opacity: false, preview: true, hue: true, interaction: {hex: false,rgba: true,hsla: false,hsva: false,cmyk: false,input: false,clear: false,save: false}}
        });
        pickrforeground.on('change', (...args) => { let color = args[0].toRGBA(); foregroundRed = color[0]; foregroundGreen = color[1]; foregroundBlue = color[2]; });

        //! Couleur du label
        let labelRed = labelGreen = labelBlue = 0;
        let labelAlpha = 1;
        const pickrlabel = Pickr.create({
            el: '.color-picker-label',
            theme: 'classic',
            swatches: ['rgba(244, 67, 54, 1)','rgba(233, 30, 99, 0.95)','rgba(156, 39, 176, 0.9)','rgba(103, 58, 183, 0.85)','rgba(63, 81, 181, 0.8)','rgba(33, 150, 243, 0.75)','rgba(3, 169, 244, 0.7)','rgba(0, 188, 212, 0.7)','rgba(0, 150, 136, 0.75)','rgba(76, 175, 80, 0.8)','rgba(139, 195, 74, 0.85)','rgba(205, 220, 57, 0.9)','rgba(255, 235, 59, 0.95)','rgba(255, 193, 7, 1)'],
            components: { opacity: false, preview: true, hue: true, interaction: {hex: false,rgba: true,hsla: false,hsva: false,cmyk: false,input: false,clear: false,save: false}}
        });
        pickrlabel.on('change', (...args) => { let color = args[0].toRGBA(); labelRed = color[0]; labelGreen = color[1]; labelBlue = color[2]; labelAlpha = color[3]; });
        
    </script>
<?php
    include_once("./includes/footer.inc.php");
?>