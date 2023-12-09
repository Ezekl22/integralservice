<div class="modal fade" id="<?php echo $popUpM->getId(); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerPop__background">
                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                <h2 class="modal-title fs-5" id="exampleModalLabel"><?php //echo $popUpM->titulo; ?></h2>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <?php echo $popUpM->getDatosCuerpo(); ?>
                <!-- <input type="text" class="mb-4 mx-5" placeholder="usuario">
                <input type="text" class="mx-5"placeholder="contraseña">
                <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                            recuperar contraseña
                        </button>
                </div> -->
            </div>
            <div class="modal-footer d-flex justify-content-center headerPop__background">
                <?php
                    foreach ($popUpM->getbotones() as $boton) {
                        if ($boton['tipo'] == 'button') {?>
                            <button type="button" class="btn button me-5" data-bs-dismiss="modal"><?php echo $boton['texto']; ?></button>
                        <?php } else{ ?>
                            <a aria-label="Close" class="btn button " href="<?php echo $boton['href']; ?>"><?php echo $boton['texto']; ?></a>
                        <?php }
                    }
                ?>
                <!-- <button type="button" class="btn button me-5" data-bs-dismiss="modal">Cancelar</button>
                <a aria-label="Close" class="btn button " href="index.php?module=menu">Ingresar</a> -->
            </div>
        </div>
    </div>
 </div>
<!--<div class="modal fade" id="inicioSesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header headerPop__background">
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Inicio de sesion</h2>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <input type="text" class="mb-4 mx-5" placeholder="usuario">
                        <input type="text" class="mx-5"placeholder="contraseña">
                        <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                                    recuperar contraseña
                                </button>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center headerPop__background">
                        <button type="button" class="btn button me-5" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="cargarMenu()" data-bs-dismiss="modal" aria-label="Close" class="btn button ">Ingresar</button>
                    </div>
            </div>
        </div>
</div>
<div class="modal fade" id="recuperarCon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header headerPop__background">
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Recuperar contraseña</h2>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <div class="d-flex mb-4 mx-5">ingrese su correo electronico y recibira un codigo de verificacion.</div>
                        <input type="text" class="mx-5 mb-4" placeholder="Email">
                    </div>
                    <div class="modal-footer d-flex justify-content-center headerPop__background"> 
                        <button type="button" class="btn me-5 button" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#ingCodigo">
                                Enviar
                        </button>
                    </div>
            </div>
        </div>
</div>
<div class="modal fade" id="ingCodigo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header headerPop__background">
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Recuperar contraseña</h2>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <div class="d-flex mb-4 mx-5">Ingrese el codigo que se envio a su correo.</div>
                        <input type="text" class="mx-5 mb-4" placeholder="Código">
                    </div>
                    <div class="modal-footer d-flex justify-content-center headerPop__background"> 
                        <button type="button" class="btn me-5 button" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#nuevaCont">
                                Verificar
                        </button>
                    </div>
            </div>
        </div>
</div>
<div class="modal fade" id="nuevaCont" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header headerPop__background">
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Recuperar contraseña</h2>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <div class="d-flex mb-4 mx-5">Ingrese la nueva contraseña.</div>
                        <input type="text" class="mx-5 mb-4" placeholder="Nueva contraseña">
                        <input type="text" class="mx-5 mb-4" placeholder="Repita la contraseña">
                    </div>
                    <div class="modal-footer d-flex justify-content-center headerPop__background"> 
                        <button type="button" class="btn me-5 button" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn button" data-bs-toggle="modal" data-bs-target="#inicioSesion">
                                Guardar
                        </button>
                    </div>
            </div>
        </div>
</div> -->