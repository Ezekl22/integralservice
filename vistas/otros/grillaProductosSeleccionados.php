<table class="grilla__contenedor border-0">
    <tr class="grilla grilla__cabecera">
        <th>Cliente</th>
        <th>Comprobante</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Punto de venta</th>
        <th>Total</th>
        <th>Acciones</th>
    </tr id="cuerpoGrilla">
    <!-- <?php //foreach ($presupuestos as $presupuesto) { ?>
        <tr class="grilla__cuerpo">
            <td><?php echo $presupuestoCtr->getNombreClienteById($presupuesto['idcliente']); ?></td>
            <td><?php echo $presupuesto['nrocomprobante']; ?></td>
            <td><?php echo $presupuesto['tipo']; ?></td>
            <td><?php echo $presupuesto['estado']; ?></td>
            <td><?php echo $presupuesto['fecha']; ?></td>
            <td><?php echo $presupuesto['puntoventa']; ?></td>
            <td><?php echo '$'.number_format($presupuesto['total'], 2); ?></td>
            <td>
                <?php if($presupuesto['estado'] != 'Facturado') {?>
                    <a class="icono__contenedor me-2 ms-2" title="Cambiar estado" href="index.php?module=presupuestos&action=cambiarestado&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoCambiarEstado.svg" alt="icono de cambiar estado">
                    </a>
                <?php } else {?>
                    <label class="icono__contenedor me-2 ms-2" title="Cambiar estado">
                        <img class="icono__imagen svg-disabled-color" src="./assets/img/iconoCambiarEstadoDeshabilitado.svg" alt="icono de cambiar estado">
                    </label>
                <?php }?>
                <a class="icono__contenedor me-2" title="ver" href="index.php?module=presupuestos&action=see&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                    <img class="icono__imagen" src="./assets/img/iconoVer.png" alt="icono de ver">
                </a>
                <?php if($presupuesto['estado'] != 'Facturado') {?>
                    <a class="icono__contenedor me-2" title="Facturar" href="index.php?module=presupuestos&action=facturar&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoFacturar.svg" alt="icono de Facturar">
                    </a>
                <?php } else {?>
                    <label class="icono__contenedor me-2" title="Facturar">
                        <img class="icono__imagen" src="./assets/img/iconoFacturarDeshabilitado.svg" alt="icono de Facturar">
                    </label>
                <?php }?>
                
                <?php if($presupuesto['estado'] != 'Facturado') {?>
                    <a class="icono__contenedor me-2" title="Editar" href="index.php?module=presupuestos&action=edit&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                    </a>
                <?php } else {?>
                    <label class="icono__contenedor me-2" title="Editar">
                        <img class="icono__imagen" src="./assets/img/iconoEditarDeshabilitado.png" alt="icono de editar deshabilitado">
                    </label>
                <?php }?>
                <a class="icono__contenedor me-2" title="Cancelar" href="index.php?module=presupuestos&action=delete&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                    <img class="icono__imagen" src="./assets/img/iconoCancelar.png" alt="icono de cancelar">
                </a>
            </td>
        </tr>
    <?php// } ?> -->
</table>