<div class="border w-95 mt-3 mb-5 rounded-4">
    <div class="table-responsive">
        <table class="table grilla__contenedor w-95 border-0">
            <thead>
                <tr class="grilla grilla__cabecera">
                    <?php
                    foreach ($grillaMdl->getDatosCabecera() as $datoCabecera) {
                        echo "<th>$datoCabecera</th>";
                    }
                    ?>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grillaMdl->getDatosCuerpo() as $datoCuerpo) { ?>
                    <tr class="grilla__cuerpo">
                        <?php $index = count($grillaMdl->getDatosCabecera());
                        for ($i = 1; $i <= $index; $i++) {
                            $valor = $datoCuerpo[$i];
                            $style = '';

                            if ($gestionPantallaCtr->getModule() == "productos" && $i == 4) {
                                if ($valor == 0) {
                                    $style = 'style="background-color: rgba(139, 0, 0, 0.7);"';
                                } elseif ($valor > 0 && $valor <= 5) {
                                    $style = 'style="background-color: rgba(255, 165, 0, 0.6);"';
                                }
                            }

                            echo "<td $style>$valor</td>";
                        }
                        ?>
                        <td>
                            <!--------------- ACCIONES ----------------->
                            <?php
                            foreach ($grillaMdl->getAcciones() as $accion) {
                                switch ($accion) {
                                    case '0': //EDITAR
                                        if (in_array($gestionPantallaCtr->getModule(), ["presupuestos", "pedidos"]) && strtoupper($datoCuerpo['estado']) == "FACTURADO" || in_array($gestionPantallaCtr->getModule(), ["presupuestos", "pedidos"]) && strtoupper($datoCuerpo['estado']) == "ANULADO") { ?>
                                            <!-- EDITAR - DESACTIVADO-->
                                            <label class="icono__contenedor me-2" title="Editar">
                                                <img class="icono__imagen" src="./assets/img/iconoEditarDeshabilitado.png"
                                                    alt="icono de editar deshabilitado">
                                            </label>
                                        <?php } else if ($gestionPantallaCtr->getModule() != "reparaciones") { ?>
                                            <!-- EDITAR - ACTIVADO-->
                                            <a class="icono__contenedor me-2"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=edit&id=<?php echo $datoCuerpo[0];
                                                                                                                                        echo $gestionPantallaCtr->getModule() == "presupuestos" ? "&type=" . $datoCuerpo[3] : ""; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                            </a>
                                        <?php }
                                        break;
                                    case '1': //ELIMINAR
                                        if ($gestionPantallaCtr->getModule() === "usuarios" && strtoupper($datoCuerpo[3]) === "ADMINISTRADOR BASE") { ?>
                                            <!-- ELIMINAR - DESACTIVADO -->
                                            <label class="icono__contenedor" title="Eliminar">
                                                <img class="icono__imagen svg-disabled-color"
                                                    src="./assets/img/iconoEliminarDeshabilitado.svg" alt="icono de eliminar">
                                            </label>
                                        <?php } else { ?>
                                            <!-- ELIMINAR - ACTIVADO -->
                                            <a class="icono__contenedor"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=delete&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen " src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                            </a>
                                        <?php }
                                        break;
                                    case '2': //ANULAR
                                        if (strtoupper($datoCuerpo['estado']) == "FACTURADO" || strtoupper($datoCuerpo['estado']) == "ANULADO") { ?>
                                            <!-- ANULAR - DESACTIVADO -->
                                            <label class="icono__contenedor me-2" title="Anular">
                                                <img class="icono__imagen" src="./assets/img/iconoAnularDeshabilitar.png"
                                                    alt="icono de anular">
                                            </label>
                                        <?php } else { ?>
                                            <!-- ANULAR - ACTIVADO -->
                                            <a class="icono__contenedor me-2" title="Anular"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=annul&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoAnular.png" alt="icono de anular">
                                            </a>
                                        <?php }
                                        break;
                                    case '3': //VER
                                        if (strtoupper($datoCuerpo[4]) != "PENDIENTE PRESUPUESTO") { ?>
                                            <a class="icono__contenedor me-2" title="ver"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=see&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoVer.png" alt="icono de ver">
                                            </a>
                                        <?php } else { ?>
                                            <label class="icono__contenedor me-2" title="ver">
                                                <img class="icono__imagen" src="./assets/img/iconoVerDeshabilitado.png" alt="icono de ver">
                                            </label>
                                        <?php }
                                        break;
                                    case '4': //CAMBIAR ESTADO
                                        if (strtoupper($datoCuerpo[4]) != "PRESUPUESTADO" || strtoupper($datoCuerpo[3]) == "VENTA") { ?>
                                            <!-- CAMBIAR ESTADO - DESACTIVADO -->
                                            <label class="icono__contenedor me-2" title="Cambiar Estado">
                                                <img class="icono__imagen" src="./assets/img/iconoCambiarEstadoDeshabilitado.svg"
                                                    alt="icono de Cambiar Estado">
                                            </label>
                                        <?php } else { ?>
                                            <!-- CAMBIAR ESTADO - ACTIVO -->
                                            <a class="icono__contenedor me-2" title="Cambiar Estado"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=cambiarestado&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoCambiarEstado.svg"
                                                    alt="icono de Cambiar Estado">
                                            </a>
                                        <?php }
                                        break;
                                    case '5': //VER
                                        if (strtoupper($datoCuerpo[4]) != "PENDIENTE PRESUPUESTO") { ?>
                                            <a class="icono__contenedor me-2" title="ver"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=see&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoVer.png" alt="icono de ver">
                                            </a>
                                        <?php } else { ?>
                                            <label class="icono__contenedor me-2" title="ver">
                                                <img class="icono__imagen" src="./assets/img/iconoVerDeshabilitado.png" alt="icono de ver">
                                            </label>
                                        <?php }
                                        break;
                                    case '6': //FACTURAR
                                        if (strtoupper($datoCuerpo['estado']) == "PRESUPUESTADO" && strtoupper($datoCuerpo['tipo']) == "VENTA" || strtoupper($datoCuerpo['estado']) == "REPARADO") { ?>
                                            <!-- FACTURAR - ACTIVO -->
                                            <a class="icono__contenedor me-2"
                                                title="<?php echo $gestionPantallaCtr->getModule() == 'presupuestos' ? 'Facturar' : 'Cargar factura' ?>"
                                                href="index.php?module=<?php echo $gestionPantallaCtr->getModule(); ?>&action=facturar&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoFacturar.svg" alt="icono de Facturar">
                                            </a>
                                        <?php } else { ?>
                                            <!-- FACTURAR - DESACTIVADO -->
                                            <label class="icono__contenedor me-2"
                                                title="<?php echo $gestionPantallaCtr->getModule() == 'presupuestos' ? 'Facturar' : 'Cargar factura' ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoFacturarDeshabilitado.svg"
                                                    alt="icono de Facturar">
                                            </label>
                                        <?php }
                                        break;
                                    case '7': //REPARAR
                                        if (strtoupper($datoCuerpo[4]) == "PENDIENTE REPARACION") { ?>
                                            <a class="icono__contenedor me-2" title="Reparar"
                                                href="index.php?module=reparaciones&action=repair&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconReparacion.png" alt="icono de reparar">
                                            </a>
                                        <?php } else { ?>
                                            <label class="icono__contenedor me-2" title="Reparar">
                                                <img class="icono__imagen" src="./assets/img/iconReparacionDeshabilitado.jpg"
                                                    alt="icono de reparar">
                                            </label>
                                        <?php }
                                        break;
                                    case '8': //EVALUAR
                                        if (strtoupper($datoCuerpo[4]) != "REPARADO" && strtoupper($datoCuerpo[4]) != "FACTURADO" && strtoupper($datoCuerpo[4]) != "PRESUPUESTADO") { ?>
                                            <a class="icono__contenedor me-2" title="Evaluar"
                                                href="index.php?module=reparaciones&action=evaluate&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoEvaluar.png" alt="icono de evaluar">
                                            </a>
                                        <?php } else { ?>
                                            <label class="icono__contenedor me-2" title="Evaluar">
                                                <img class="icono__imagen" src="./assets/img/iconoEvaluarDeshabilitado.png"
                                                    alt="icono de reparar">
                                            </label>
                                        <?php }
                                        break;
                                    case '9': //HABILITAR - DESHABILITAR
                                        if (strtoupper($datoCuerpo[8]) == 'HABILITADO') { ?>
                                            <a class="icono__contenedor me-2" title="Deshabilitar"
                                                href="index.php?module=productos&action=deshabilitar&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoHabilitarProducto.png" alt="icono de habilitar">
                                            </a>
                                        <?php } else { ?>
                                            <a class="icono__contenedor me-2" title="Habilitar"
                                                href="index.php?module=productos&action=habilitar&id=<?php echo $datoCuerpo[0]; ?>">
                                                <img class="icono__imagen" src="./assets/img/iconoDeshabilitarProducto.png" alt="icono de deshabilitar">
                                            </a>
                            <?php }
                                        break;
                                }
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>