<nav class="navbar navbar-expand-lg bg-primary fw-bolder">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="./index.php"><img src="images/logo.png" alt="Notre Logo" style="width: 1.5em;"> Photo4You</a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav" style="display: flex; justify-content: space-between; width: 100%;">
                <div class="navbarPerso d-flex flex-lg-row  flex-column text-center">
                    <li class="nav-item dropdown">
                        <a  class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Créer un QR Codes
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item fw-bolder" href="./createVcard.php"><i class="fa-regular fa-id-card"></i> Carte de contact</a>
                            <a class="dropdown-item fw-bolder" href="./createQrcode.php?type=lien"><i class="fa-solid fa-link"></i> Lien</a>
                            <a class="dropdown-item fw-bolder" href="./createQrcode.php?type=text"><i class="fa-solid fa-file-lines"></i> Texte</a>
                            <a class="dropdown-item fw-bolder" href="./createQrcode.php?type=mail"><i class="fa-solid fa-envelope"></i> Email</a>
                            <a class="dropdown-item fw-bolder" href="./createQrcode.php?type=telephone"><i class="fa-solid fa-phone"></i> Téléphone</a>
                            <a class="dropdown-item fw-bolder" href="./createSMSandLOC.php?type=sms"><i class="fa-solid fa-comment-sms"></i> SMS</a>
                            <a class="dropdown-item fw-bolder" href="./createSMSandLOC.php?type=localisation"><i class="fa-solid fa-location-dot"></i> Localisation</a>
                            <a class="dropdown-item fw-bolder" href="./createWifi.php"><i class="fa-solid fa-wifi"></i> Wifi</a>
                        </div>
                    </li>
                </div>

                <div class="navbarPerso d-flex flex-lg-row  flex-column text-center">
                    <a onclick="changeTheme()" class="btn mx-2 text-light" role="button" id="colorChanger"><i class="fas fa-moon"></i></a>
                    <?php if (isset($_SESSION['id'])): ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropstart</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fw-bold" href="#">Mes QRCodes</a></li>
                                <li class="d-flex align-items-center justify-content-center"><a class="btn btn-danger fw-bold" href="./logout.php" role="button"><i class="fa-solid fa-power-off"></i> Déconnexion</a></li>
                            </ul>
                            <button type="button" class="text-light fw-bold btn bg-success">
                                <?= $_SESSION['pseudo']; ?>
                            </button>
                        </div>

                    <?php else: ?>
                        <a class="btn btn-success mx-2" href="./login.php" role="button"><i class="fa-solid fa-user-plus"></i> Inscription</a>
                        <a class="btn btn-dark bg-success-subtle mx-2" href="./login.php?login" role="button"><i class="fa-solid fa-right-to-bracket"></i>  Connexion</a>
                    <?php endif; ?>
                </div>
            </ul>
        </div>
    </div>
</nav>
<div id="toastBox"></div>