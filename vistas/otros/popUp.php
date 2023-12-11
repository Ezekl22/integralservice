<div class="modal fade" id="<?php echo $popUpM->getId(); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form action="<?php echo $popUpM->getAccion();?>" method="POST">
        <div class="modal-content">
            <div class="modal-header headerPop__background">
                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                <h2 class="modal-title fs-5" id="exampleModalLabel"><?php echo $popUpM->getTitulo(); ?></h2>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
                <div class="modal-body d-flex flex-column">
                    <?php echo $popUpM->getDatosCuerpo(); ?>
                </div>
                <div class="modal-footer d-flex justify-content-center headerPop__background">
                    <?php
                        foreach ($popUpM->getbotones() as $boton) {
                            switch ($boton['tipo']) {
                                case 'button':
                                    ?>
                                        <button type="button" class="btn button me-5" data-bs-dismiss="modal"><?php echo $boton['texto']; ?></button>
                                    <?php
                                    break;
                                case 'a':
                                    ?>
                                        <a aria-label="Close" class="btn button " href="<?php echo $boton['href']; ?>"><?php echo $boton['texto']; ?></a>
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