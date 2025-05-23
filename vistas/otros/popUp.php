<div class="modal fade" id="<?php echo $popUpM->getId(); ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div <?php echo $popUpM->getId() == "grillaProductos" ? "class='modal-dialog justify-content-center d-flex' style='max-width:none;'" : "class='modal-dialog '" ?>>
        <form action=" <?php echo $popUpM->getAccion(); ?>" method="POST" onsubmit="return validarFormulario()">
            <div class="modal-content" <?php echo $popUpM->getId() == "grillaProductos" ? "style='width:80vw;'" : "" ?>>
                <div class="modal-header headerPop__background">
                    <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo"
                        alt="logo de integral Service">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">
                        <?php echo $popUpM->getTitulo(); ?>
                    </h2>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if ($popUpM->getId()) { ?>
                    <div class="modal-body d-flex flex-column align-items-center">
                        <?php switch ($popUpM->getId()) {
                            case 'inicioSesion':
                                ?>
                                <input id="mail" type="email" class="mb-4 mx-5 form-control w-75" name="mail" placeholder="Mail"
                                    required>
                                <div class="input-group w-75">
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                                    <button class="btn button" type="button" id="seePassword" title="ver contraseña" onclick="togglePassword(this, event);">
                                        <img class="icono__imagen" id="iconVerContrasena" src="./assets/img/iconoVerContrasena.png" alt="icono de ver/ocultar contraseña">
                                    </button>
                                </div>
                                <?php break;
                            case 'delete': ?>
                                <label class="mb-4 mx-5">
                                    ¿Esta seguro/a que desea eliminar el elemento seleccionado?
                                </label>
                                <?php break;
                            case 'annul': ?>
                                <label class="mb-4 mx-5">
                                    ¿Esta seguro/a que desea anular el elemento seleccionado? 
                                </label>
                                <?php break;
                            case 'grillaProductos': ?>
                                <div class="modal-body d-flex flex-column align-items-center" id="contGrillaProducto"></div>
                                <?php
                                break;
                            default:
                                ?>
                                <div id="mensaje-error" class="text-danger">ERROR: debe ingresar el body del popup</div>
                                <?php break;
                        } ?>
                    </div>
                <?php } ?>
                <div class="modal-footer d-flex justify-content-center headerPop__background">
                    <?php
                    foreach ($popUpM->getbotones() as $boton) {
                        switch ($boton['tipo']) {
                            case 'button':
                                ?>
                                <button type="button" class="btn button me-5" aria-label="Close" data-bs-dismiss="modal" <?php echo isset($boton['onclick']) ? 'onclick="' . $boton['onclick'] . '"' : ''; ?>>
                                    <?php echo $boton['texto']; ?>
                                </button>
                                <?php
                                break;
                            case 'a':
                                ?>
                                <a aria-label="Close" class="btn button " href="<?php echo $boton['href']; ?>">
                                    <?php echo $boton['texto']; ?>
                                </a>
                                <?php
                                break;
                            case 'submit':
                                ?>
                                <input class="btn button" type="submit" value="<?php echo $boton['texto']; ?>">
                                <?php
                                break;
                        }
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>