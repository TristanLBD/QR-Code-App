<?php
    include_once("./includes/connect.inc.php");
    if(!isset($_SESSION['id'])) { header('Location: login.php'); die(); }

    if(isset($_GET["id"]) && is_numeric($_GET['id']) && $_GET["id"] > 0  && file_exists('./assets/QRImages/'.$_GET['id'].'.png')) {
        $actionType = "Modifier";

        if(isset($_GET["id"]) && is_numeric($_GET['id']) && $_GET["id"] > 0  && file_exists('./assets/QRImages/'.$_GET['id'].'.png')) {
            $actionType = "Modifier";

            $qrcode = new Lien(['db'=>$DB]);
            $values = $qrcode->getQrCode('vcard',$_GET["id"],$_SESSION['id']);
            // if($values) {
            //     $firstInputValue = $values['wifi'];
            //     $secondInputValue = $values['password'];
            //     $thirddInputValue = $values['encryption'];
            //     $fourthInputValue = $values['visible'];
            // }
        }
    }

    include_once("./includes/header.inc.php");
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

    <div class="row">
        <div class="col-12 col-md-8">
            <div id="title-border"><span>Créer une carte de contact</span></div>
            <form method="post" action="generatevcard.php" id="qrForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-control-group col-12 col-md-6">
                        <label for="QR-name" class="form-label fw-bolder"><i class="fa-solid fa-signature"></i> Nom :</label>
                        <input type="text" value="<?php if(isset($values) && $values) {echo($values['nom']);} ?>" class="form-control col-6" name="QR-name" id="QR-name" aria-describedby="emailHelp">
                    </div>

                    <div class="form-control-group col-12 col-md-6">
                        <label for="QR-firstname" class="form-label fw-bolder"><i class="fa-solid fa-signature"></i> Prenom :</label>
                        <input type="text" class="form-control col-6" value="<?php if(isset($values) && $values) {echo($values['prenom']);} ?>" name="QR-firstname" id="QR-firstname" aria-describedby="emailHelp">
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-control-group col-12 mt-3">
                        <label for="QR-mail" class="form-label fw-bolder"><i class="fa-solid fa-envelope"></i> Email :</label>
                        <input type="mail" class="form-control" value="<?php if(isset($values) && $values) {echo($values['email']);} ?>" name="QR-mail" id="QR-mail" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row">
                    <div class="form-control-group col-12 col-md-6 mt-3">
                        <label for="QR-site" class="form-label fw-bolder"><i class="fa-solid fa-link"></i> Site :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['site']);} ?>" name="QR-site" id="QR-site" aria-describedby="emailHelp">
                    </div>

                    <div class="form-control-group col-12 col-md-6 mt-3">
                        <label for="QR-phone" class="form-label fw-bolder"><i class="fa-solid fa-mobile"></i> Téléphone :</label>
                        <input type="tel" class="form-control" value="<?php if(isset($values) && $values) {echo($values['telephone']);} ?>" name="QR-phone" id="QR-phone" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row">
                    <div class="form-control-group col-12 col-md-6 mt-3">
                        <label for="QR-company" class="form-label fw-bolder"><i class="fa-solid fa-building"></i> Entreprise :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['entreprise']);} ?>" name="QR-company" id="QR-company" aria-describedby="emailHelp">
                    </div>

                    <div class="form-control-group col-12 col-md-6 mt-3">
                        <label for="QR-job" class="form-label fw-bolder"><i class="fa-solid fa-user"></i> <i class="fa-solid fa-suitcase"></i> <i class="fa-solid fa-briefcase"></i> Job :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['job']);} ?>" name="QR-job" id="QR-job" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row">
                    <div class="form-control-group col-12 col-md-4 mt-3">
                        <label for="QR-country" class="form-label fw-bolder"><i class="fa-solid fa-globe"></i> Pays :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['pays']);} ?>" name="QR-country" id="QR-country" aria-describedby="emailHelp">
                    </div>

                    <div class="form-control-group col-12 col-md-4 mt-3">
                        <label for="QR-region" class="form-label fw-bolder"><i class="fa-solid fa-flag"></i> Region :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['region']);} ?>" name="QR-region" id="QR-region" aria-describedby="emailHelp">
                    </div>

                    <div class="form-control-group col-12 col-md-4 mt-3">
                        <label for="QR-zip" class="form-label fw-bolder"><i class="fa-solid fa-signs-post"></i> Code Postal :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['postal']);} ?>" name="QR-zip" id="QR-zip" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row">
                    <div class="form-control-group col-12 col-md-6 mt-3">
                        <label for="QR-city" class="form-label fw-bolder"><i class="fa-solid fa-city"></i> Ville :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['ville']);} ?>" name="QR-city" id="QR-city" aria-describedby="emailHelp">
                    </div>

                    <div class="form-control-group col-12 col-md-6 mt-3">
                        <label for="QR-address" class="form-label fw-bolder"><i class="fa-solid fa-house"></i> Adresse :</label>
                        <input type="text" class="form-control" value="<?php if(isset($values) && $values) {echo($values['rue']);} ?>" name="QR-address" id="QR-address" aria-describedby="emailHelp">
                    </div>
                </div>

                <div class="row">
                    <div class="form-control-group col-12 mt-3">
                        <label for="QR-note" class="form-label fw-bolder"><i class="fa-solid fa-note-sticky"></i> Note :</label>
                        <div class="form-floating">
                            <textarea class="form-control" style="padding: 8px; height: 60px;" name="QR-note" placeholder="Leave a comment here" id="QR-note" style="height: 100px"><?php if(isset($values) && $values) {echo($values['note']);} ?></textarea>
                        </div>
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
                    <p class="fs-1 fw-bolder text-decoration-underline">V-Card</p>
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
                    formData.append('input-type', 'vcard' );
                    formData.append('QR-name', $('#QR-name').val());
                    formData.append('QR-firstname', $('#QR-firstname').val());
                    formData.append('QR-mail', $('#QR-mail').val());
                    formData.append('QR-site', $('#QR-site').val());
                    formData.append('QR-phone', $('#QR-phone').val());
                    formData.append('QR-company', $('#QR-company').val());
                    formData.append('QR-job', $('#QR-job').val());
                    formData.append('QR-country', $('#QR-country').val());
                    formData.append('QR-region', $('#QR-region').val());
                    formData.append('QR-zip', $('#QR-zip').val());
                    formData.append('QR-city', $('#QR-city').val());
                    formData.append('QR-address', $('#QR-address').val());
                    formData.append('QR-note', $('#QR-note').val());
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
                    var requiredFields = ['QR-name','QR-firstname','QR-mail','QR-site','QR-phone','QR-company','QR-job','QR-country','QR-region','QR-zip','QR-city','QR-address','QR-note',];
                    var isAnyFieldFilled = requiredFields.some(function(fieldName) {
                        var value = formData.get(fieldName);
                        //! verifie qu'il existe bien dans le formData et que different de vide
                        return value !== 'undefined' && value !== undefined && value !== null && value !== "";
                    });

                    //! Si aucun champ remplis , on alerte l'utilisateur
                    if (!isAnyFieldFilled) {showToast("warning", "Au moins un des champs de contact doit être rempli.");return;}

                    $.ajax({
                        type: "POST",
                        // url: "generateqrcode.php",
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
                                    // url: "INSERT.php",
                                    url: "generatevcard.php",
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