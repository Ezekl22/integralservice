<?php 

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = $action != ''&& isset($_GET['id']) ? $_GET['id'] : '';
$presupuestoCtr = New PresupuestoCtr();

// $clienteCtr = new ClientController();
// $clienteCte->getClienteById();

?>
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
            <div class="grilla contenedor__mayor-grilla d-flex flex-column align-items-center rounded-4">
                <div class="d-flex flex-row contenedor__mayor align-items-start mt-4">
                    <div class="d-flex w-100 alig-items-end">
                        <div class="form-check ms-3 text__white">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Facturado
                            </label>
                        </div>
                        <div class="form-check ms-4 text__white">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                No Facturado
                            </label>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-center">
                        <div class="input-group w-75 input-group-sm">
                            <label class="input-group-text input-group-sm" for="inputGroupSelect01">Tipo</label>
                            <select class="form-select input-group-sm" id="inputGroupSelect01">
                                <option selected value="0">Todos</option>
                                <option value="1">Ventas</option>
                                <option value="2">Reparaciones</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-end">
                        <div class="input-group input-group-sm w-75">
                            <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                            <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                        </div>
                    </div>
                </div>
                <div class="border contenedor__mayor mt-3 mb-5 rounded-4">
                    
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
                        </tr>
                        <?php foreach ($presupuestos as $presupuesto) { ?>
                            <tr class="grilla__cuerpo">
                                <td><?php echo $presupuestoCtr->getNombreClienteById($presupuesto['idcliente']); ?></td>
                                <td><?php echo $presupuesto['nrocomprobante']; ?></td>
                                <td><?php echo $presupuesto['tipo']; ?></td>
                                <td><?php echo $presupuesto['estado']; ?></td>
                                <td><?php echo $presupuesto['fecha']; ?></td>
                                <td><?php echo $presupuesto['puntoventa']; ?></td>
                                <td><?php echo '$'.number_format($presupuesto['total'], 2); ?></td>
                                <td>
                                    <a class="icono__contenedor me-2 ms-2" href="index.php?module=presupuestos&action=cambiarestado&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoCambiarEstado.svg" alt="icono de cambiar estado">
                                    </a>
                                    <button class="icono__contenedor me-2 ms-2" style="border: none; background: none;" data-bs-target="#ver" data-bs-toggle="modal">
                                        <img class="icono__imagen" src="./assets/img/iconoVer.png" alt="icono de ver">
                                    </button>
                                    <a class="icono__contenedor me-2" href="index.php?module=presupuestos&action=facturar&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoFacturar.svg" alt="icono de Facturar">
                                    </a>
                                    <a class="icono__contenedor me-2" href="index.php?module=presupuestos&action=edit&id=<?php echo $presupuesto['idpresupuesto']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                    </a>
                                    <a class="icono__contenedor me-2" href="index.php?module=presupuestos&action=delete&id=<?php echo $presupuesto['idpresupuesto']; ?>">
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
        <div class="modal fade" id="ver" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog justify-content-center d-flex" style="max-width:none;">
                <div class="modal-content mx-3" style="width:80vw;">
                    <div class="modal-header headerPop__background">
                        <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Productos</h2>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex flex-column align-items-center">
                        <div class="d-flex flex-row w-100 mb-3">
                            <div class="d-flex align-items-start w-50 flex-column ms-5">
                                <h4> Integral Service</h4>
                                <div>Servico tecnico de equipos de impresion</div>
                            </div>
                            <div class="d-flex align-items-end w-50 flex-column me-5">
                                <div class="d-flex w-100 d-flex align-items-start">
                                    <b class="me-2">Dirección: </b> Balcarce 653 <b class="mx-2">Provincia: </b> Ente Ríos <b class="mx-2">Localidad: </b> Concordia
                                </div> 
                                <div class="d-flex w-100 d-flex align-items-start">
                                    <b class="me-2">CUIT: </b> 20-38926571-6
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row border-bottom border-secondary w-95"></div>
                        <div class="d-flex align-items-start w-100 flex-column mt-3">
                            <h5 class="ms-5">Cliente</h5>
                            <div class="d-flex align-items-start w-100 flex-column mt-3">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center headerPop__background">
                        <button type="button" class="btn button" data-bs-dismiss="modal">Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

