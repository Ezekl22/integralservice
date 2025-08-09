<!DOCTYPE html>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";
$action = isset($_GET['action']) ? $_GET['action'] : "";
$gestionPantallaCtr = new GestionPantallasControlador();
$presupuestoCtr = PresupuestoCtr::getInstance();
$presupuesto = $presupuestoCtr->getPresupuestoById($id);
$reparacion = $presupuestoCtr->getReparacionPresupuestoById($id);
$cliente = $presupuestoCtr->getClienteById($presupuesto->getIdCliente());
$productoCtr = ProductoCtr::getInstance();
$json = json_encode($productoCtr->getAllRepuestos());
$productos = $presupuestoCtr->getProductosPresupuestoById($id);
$jsonProductosPre = json_encode(value: $productos);
echo "<script>const productos = $json; screenCenter('contenedor');</script>";
?>
<html>

<head>
    <title><?php echo $action == 'repair' ? 'Reparacion' : 'Evaluación' ?></title>
</head>

<body>
    <main class="d-flex flex-column align-items-center mt-2 mb-4 main__flex" id="editPresupuesto">
        <article class="mt-4">
            <h2 class="main__title mb-5">
                <?php echo $action == 'repair' ? 'Reparacion' : 'Evaluación'; ?>
            </h2>
        </article>
        <article class="editar__contenedor rounded-4">
            <form
                action="index.php?module=reparaciones&action=<?php echo $action == 'repair' ? 'repaired' : 'evaluated' ?>&id=<?php echo $id ?>"
                method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                <div class="d-flex flex-column align-items-center contenedor__mayor" id="contenedor">
                    <h4 class="mt-3 text__white mt-2">
                        Equipo a <?php echo $action == 'repair' ? 'reparar' : 'evaluar'; ?>
                    </h4>
                    <div class="mt-5 d-flex flex-row w-100">
                        <div class="input-group input-group-sm mx-7">
                            <label class="input-group-text" for="marca" id="inputGroup-sizing-sm">Cliente:</label>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" id="idcliente" name="idcliente"
                                value="<?php echo $cliente['nombre'] . ' ' . $cliente['apellido'] ?>" disabled required>
                        </div>
                        <div class="input-group input-group-sm mx-7">
                            <label class="input-group-text" for="marca" id="inputGroup-sizing-sm">Marca:</label>
                            <input type="text" class="form-control" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-sm" id="marca" name="marca"
                                value="<?php echo $reparacion['marca'] ?>" disabled required>
                        </div>
                        <div class="input-group input-group-sm mx-7">
                            <label class="input-group-text" for="modelo" id="inputGroup-sizing-sm">Modelo:</label>
                            <input type="text" class="form-control w-25" id="modelo" name="modelo"
                                value="<?php echo $reparacion['modelo'] ?>" disabled required>
                        </div>
                    </div>
                    <div class="mt-4 d-flex flex-row w-100">
                        <div class="input-group input-group-sm mx-7">

                            <label class="input-group-text" for="nroserie" id="inputGroup-sizing-sm">Numero de
                                serie:</label>
                            <input type="text" class="form-control w-25" id="nroserie" name="nroserie"
                                value="<?php echo $reparacion['numeroserie'] ?>" disabled required>
                        </div>
                        <div class="input-group input-group-sm mx-7">

                            <label class="input-group-text" for="Fecha" id="inputGroup-sizing-sm">Fecha:</label>
                            <input type="text" class="form-control w-25" id="Fecha" name="Fecha"
                                value="<?php echo $presupuesto->getFecha() ?>" disabled required>
                        </div>
                        <div class="input-group input-group-sm mx-7">

                            <label class="input-group-text" for="estado" id="inputGroup-sizing-sm">Estado:</label>
                            <input type="text" class="form-control w-25" id="estado" name="estado"
                                value="<?php echo $presupuesto->getEstado() ?>" disabled required>

                        </div>
                    </div>
                    <div class="input-group w-75 mt-4">
                        <label class="input-group-text" for="descripcion" id="input-group">Descripción:</label>
                        <textarea class="form-control resizeTextArea" aria-label="" id="descripcion" name="descripcion"
                            disabled><?php echo $reparacion['descripcion'] ?></textarea>
                    </div>
                    <div class="d-flex flex-column align-items-center contenedor__mayor mt-5" id="contenedor">

                        <div class="d-flex flex-column align-items-center contenedor__mayor" id="contGrillaFormulario">

                            <h4 class=" text__white">
                                Mano de obra y repuestos
                            </h4>

                            <div class="input-group input-group-sm my-4 w-50">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="manodeobra" id="inputGroup-sizing-sm">Valor de
                                        la mano de obra: $</label>
                                    <input type="number" class="form-control w-25" id="manodeobra" name="manodeobra"
                                        step="any" placeholder="0.00" oninput="formatMoney(this)"
                                        value="<?php echo $reparacion['manodeobra'] ?>" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start w-100">
                                <button class="btn btn-outline-secondary button align-self-start ms-5"
                                    data-bs-target="#grillaProductos" data-bs-toggle="modal" type="button" id="agregar"
                                    onclick="mostrarGrillaProductos()" <?php echo $action == 'repair' ? 'disabled' : "" ?>>Agregar repuesto
                                </button>
                                <button class="btn btn-outline-secondary button ms-3 align-self-start" disabled
                                    onclick="quitarComponenteProducto()" type="button" id="btnQuitar">Quitar
                                    repuestos</button>
                            </div>

                            <div class="my-3 d-flex flex-column w-100" id="contProductos">
                                <?php include_once "vistas/otros/grillaProductosSeleccionados.php" ?>
                            </div>
                            <div class="d-flex" id="">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="totalProductos"
                                        id="inputGroup-sizing-sm">Total:</label>
                                    <input type="text" class="form-control" disabled aria-label="0" id="totalproductos"
                                        value="$0.00" step="any">
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly w-75">
                                <input class="my-5 btn button w-25" type="submit"
                                    value="<?php echo $action == 'repair' ? 'Reparar' : "Guardar"; ?>">
                                <a class="my-5 btn button w-25" type="button"
                                    href="index.php?module=reparaciones">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php $gestionPantallaCtr->crearPopUp(new PopUpMdl('grillaProductos', 'Productos', "", BOTONES_POPUP_PRODUCTOS, '')); ?>
        </article>
    </main>
</body>
<?php
if ($action == 'repair') {
    echo "<script>cargarGrillaProducto('presupuesto', " . $jsonProductosPre . ")</script>";
} ?>

</html>