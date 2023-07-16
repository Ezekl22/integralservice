<?php $presupuestoCtr = New PresupuestoCtr()?>
<!DOCTYPE html>
<html>
<head>
    <title>Presupuestos</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Presupuestos
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <div class="border w-75 mt-5 mb-5 rounded-4">
                    
                    <table class="grilla__contenedor border-0">
                        <tr class="grilla grilla__cabecera">
                            <th>Cliente</th>
                            <th>Numero de comprobante</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Puntoventa</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($presupuestos as $presupuesto) { ?>
                            <tr class="grilla__cuerpo">
                                <td><?php echo $presupuestoCtr->getNombreClienteById($presupuesto['idcliente']); ?></td>
                                <td><?php echo $presupuesto['nrocomprobante']; ?></td>
                                <td><?php echo $presupuesto['estado']; ?></td>
                                <td><?php echo $presupuesto['fecha']; ?></td>
                                <td><?php echo $presupuesto['puntoventa']; ?></td>
                                <td><?php echo '$'.number_format($presupuesto['total'], 2); ?></td>
                                <td>
                                    <a class="icono__contenedor me-3" href="index.php?module=presupuestos&action=edit&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                    </a>
                                    <a class="icono__contenedor" href="index.php?module=presupuestos&action=delete&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <a class="my-5 btn button" type="button" href="index.php?module=presupuestos&action=create">Crear nuevo presupuesto</a>
        </article>
    </main>
</body>
</html>

