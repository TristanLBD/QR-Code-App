                <div class="accordion mt-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><i class="fa-solid fa-palette"></i>&nbsp;Couleurs</button></h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row text-center text-decoration-underline">
                                    <div class="col-12 col-md-6 fw-bolder">
                                        Couleur du fond :
                                        <div class="color-picker-background"></div>

                                    </div>
                                    <div class="col-12 col-md-6 fw-bolder">
                                        Couleur du QR-Code :
                                        <div class="color-picker-foreground"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa-solid fa-file-lines"></i>&nbsp;Texte et&nbsp;<i class="fa-solid fa-image"></i>&nbsp;Image</button></h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row text-center ">
                                    <div class="col-12 col-md-6 fw-bolder">
                                        <div class="row">
                                            <div class="col">
                                                <label for="QR-label" class="form-label fw-bolder text-decoration-underline"><i class="fa-solid fa-tag"></i> Label :</label>
                                                <input type="text" value="<?php if(isset($values['label'])) { echo($values['label']); }?>" class="form-control" name="QR-label" id="QR-label" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="btnradio2" class="form-label fw-bolder text-decoration-underline mt-3"><i class="fa-solid fa-tag"></i> Position du label :</label><br>
                                                <div class="btn-group mb-3" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" <?php if(isset($values['labelposition']) && $values['labelposition'] == "left") { echo("checked"); }?> value="left" required name="QR-label-position" id="btnradio1" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnradio1"><i class="fa-solid fa-circle-arrow-left"></i> Gauche</label>

                                                    <input type="radio" class="btn-check" <?php if(isset($values['labelposition']) && $values['labelposition'] != "left" && $values['labelposition'] != "right" || !isset($values['labelposition'])) { echo("checked"); }?> value="center" required name="QR-label-position" id="btnradio2" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnradio2">Centre</label>

                                                    <input type="radio" class="btn-check" <?php if(isset($values['labelposition']) && $values['labelposition'] == "right") { echo("checked"); }?> value="right" required name="QR-label-position" id="btnradio3" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="btnradio3">Droite <i class="fa-solid fa-circle-arrow-right"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 fw-bolder text-center text-decoration-underline mt-3">
                                                Couleur du label :
                                                <div class="color-picker-label"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 fw-bolder">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="QR-logo" class="form-label fw-bolder text-decoration-underline">Logo :</label>
                                                    <input class="form-control" type="file" name="QR-logo" id="QR-logo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="QR-logo-size" class="form-label fw-bolder text-decoration-underline">Taille du logo :</label>
                                                <input type="range" class="form-range" value="0.5" min="0" max="1" step="0.01" name="QR-logo-size" id="QR-logo-size">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa-solid fa-gear"></i>&nbsp;Options</button></h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row text-center">
                                    <div class="col-12 col-md-6 fw-bolder">
                                        <label for="QR-size" class="form-label fw-bolder text-decoration-underline">Taille du QR-code :</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="QR-size" min="50" name="QR-size" value="<?php if(isset($values['size'])) { echo($values['size']); } else { echo("600"); } ?>" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">px</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 fw-bolder">
                                        <label for="QR-margin" class="form-label fw-bolder text-decoration-underline">Taille de la marge :</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="QR-margin" min="0" name="QR-margin" value="<?php if(isset($values['margin'])) { echo($values['margin']); } else { echo("20"); } ?>" aria-describedby="basic-addon2">
                                            <span class="input-group-text" id="basic-addon2">px</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12 col-md-6 fw-bolder">
                                        <label for="QR-error" class="form-label fw-bolder text-decoration-underline">Taux de correction d'erreur :</label>
                                        <select class="form-select" id="QR-error" name="QR-error" aria-label="Default select example">
                                            <option <?php if(isset($values['error']) && $values['error'] == "low") { echo("selected"); } ?> value="low">Low</option>
                                            <option <?php if(isset($values['error']) && $values['error'] == "medium") { echo("selected"); } ?> value="medium">Medium</option>
                                            <option <?php if(isset($values['error']) && $values['error'] == "hight") { echo("selected"); } ?> value="hight">Hight</option>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>