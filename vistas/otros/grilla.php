<div class="border w-75 mt-3 mb-5 rounded-4">
    <table class="grilla__contenedor border-0">
        <tr class="grilla grilla__cabecera">
            <?php 
                foreach ($grillaMdl->getDatosCabecera() as $datoCabecera) {
                   echo "<th>$datoCabecera</th>";
                }
            ?>
            <th>Acciones</th>
        </tr>
        <?php foreach ($grillaMdl->getDatosCuerpo() as $datoCuerpo) { ?>
            <tr class="grilla__cuerpo">
            <?php foreach ($grillaMdl->getDatosCabecera() as $datoCabecera) { 
                    echo '<td>'.$datoCuerpo[strtolower($datoCabecera)].'</td>';
                }?>
                <td>
                    <!--------------- ACCIONES ----------------->

                    <!-- VER -->
                    <?php if(in_array($gestionPantallaCtr->getModule(),["presupuestos","pedidos"])){?>
                        <a class="icono__contenedor me-2" title="ver" href="index.php?module=presupuestos&action=see&id=<?php echo $datoCuerpo[0]; ?>">
                            <img class="icono__imagen" src="./assets/img/iconoVer.png" alt="icono de ver">
                        </a>
                        <?php if(strtoupper($datoCuerpo[4]) == "FACTURADO") {?>
                    <!-- CAMBIAR ESTADO -->
                            
                        <?php } else{ ?>
                            <a class="icono__contenedor me-2 ms-2" title="Cambiar estado" href="index.php?module=presupuestos&action=cambiarestado&id=<?php echo $datoCuerpo[0]; ?>">
                                <img class="icono__imagen" src="./assets/img/iconoCambiarEstado.svg" alt="icono de cambiar estado">
                            </a>
                            <!-- FACTURAR --> 
                            <a class="icono__contenedor me-2" title="Facturar" href="index.php?module=presupuestos&action=facturar&id=<?php echo $datoCuerpo[0]; ?>">
                                <img class="icono__imagen" src="./assets/img/iconoFacturar.svg" alt="icono de Facturar">
                            </a>   
                        <?php } ?>
                    
                    <?php } ?>
                    <!-- EDITAR -->
                    <a class="icono__contenedor me-3" href="index.php?module=usuarios&action=edit&id=<?php echo $datoCuerpo[0]; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                    </a>
                    <!-- ELIMINAR-->
                    <?php if(in_array($gestionPantallaCtr->getModule(),["usuarios","clientes","proveedores","productos"])){ ?>
                        <?php if( $gestionPantallaCtr->getModule() === "usuarios" && strtoupper($datoCuerpo[3]) === "ADMINISTRADOR BASE"){ ?>
                            <label class="icono__contenedor" title="Eliminar" href="index.php?module=presupuestos&action=delete&id=<?php echo $datoCuerpo[0]; ?>">
                                <img class="icono__imagen svg-disabled-color" src="./assets/img/iconoEliminarDeshabilitado.svg" alt="icono de eliminar">
                            </label>
                        <?php } else{ ?>

                            <a class="icono__contenedor" href="index.php?module=usuarios&action=delete&id=<?php echo $datoCuerpo[0]; ?>">
                                <img class="icono__imagen " src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                            </a>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>