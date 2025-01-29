<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$PedidoCompraCtr = new PedidoCompraCtr();
$action = isset($_GET['action']) ? $_GET['action'] : '';
$pedidoCompra = $PedidoCompraCtr->getPedidoCompraById($id);
$proveedores = $PedidoCompraCtr->getAllProveedores();
$GestionPantallasCtr = new GestionPantallasControlador();
$productos = $PedidoCompraCtr->getProductosPedidoById($id);
$jsonProductosPedido = json_encode($productos);
$json = json_encode($PedidoCompraCtr->getAllProductos());
echo "<script>const productos = $json;</script>";
?>
<?php
if ($action == 'facturar' && $id != '') {

    ?>
    <html>

    <head>
        <title>Cargar Factura de Compra</title>
    </head>

    <body>
        <main class="d-flex flex-column align-items-center mt-2 mb-4 main__flex" id="editPedido">
            <article class="mt-4">
                <h2 class="main__title mb-5">
                    Cargar Factura de Compra
                </h2>
            </article>
            <article class="editar__contenedor rounded-4">
                <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                    <div class="d-flex flex-column align-items-center contenedor__mayor" id="contenedor">
                        <div class="my-3 d-flex flex-row w-100">
                            <div class="input-group input-group-sm ms-7">
                                <label class="input-group-text" for="proveedor">Proveedor:</label>
                                <select class="form-select" id="idproveedor" name="idproveedor" required>
                                    <?php foreach ($proveedores as $proveedor) { ?>
                                        <option value="<?php echo $proveedor['idproveedor'] ?>" <?php echo ($pedidoCompra->getIdProveedor() == $proveedor['idproveedor']) ? 'selected' : ''; ?>>
                                            <?php echo $proveedor['nombre'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="input-group input-group-sm mx-7">
                                <label class="input-group-text NroComprobanteTxt" for="nroComprobante"
                                    id="inputGroup-sizing-sm">Comprobante
                                    Nro:</label>
                                <input type="text" disabled class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="nrocomprobante" name="nrocomprobante"
                                    value="<?php echo $pedidoCompra->getNroComprobante() ?>" required>
                            </div>
                        </div>
                        <div class="my-3 d-flex flex-row w-100">
                            <div class="input-group input-group-sm ms-7">
                                <label class="input-group-text" for="estado" id="inputGroup-sizing-sm">Estado:</label>
                                <input type="text" class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="estado" name="estado"
                                    value="<?php echo $pedidoCompra->getEstado() ?>" disabled required>
                            </div>
                            <div class="input-group input-group-sm mx-7">
                                <label class="input-group-text" for="fecha" id="inputGroup-sizing-sm">Fecha:</label>
                                <input type="text" disabled class="form-control" aria-label="Sizing example input"
                                    aria-describedby="inputGroup-sizing-sm" id="fecha" name="fecha"
                                    value="<?php echo $pedidoCompra->getFecha() ?>" required>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center contenedor__mayor" id="contGrillaFormulario">
                            <h4 class="mt-2 text__white">
                                Productos
                            </h4>
                            <div class="d-flex justify-content-start w-100">
                                <button class="btn btn-outline-secondary button align-self-start ms-5"
                                    data-bs-target="#grillaProductos" data-bs-toggle="modal" type="button" id="agregar"
                                    onclick="mostrarGrillaProductos()">Agregar producto</button>
                                <button class="btn btn-outline-secondary button ms-3 align-self-start" disabled
                                    onclick="quitarComponenteProducto()" type="button" id="btnQuitar">Quitar
                                    productos</button>
                            </div>

                            <div class="my-3 d-flex flex-column w-100" id="contProductos">
                                <?php include_once "vistas/otros/grillaProductosSeleccionados.php" ?>
                            </div>
                            <div class="d-flex" id="">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="totalProductos"
                                        id="inputGroup-sizing-sm">Total:</label>
                                    <input type="text" class="form-control" disabled aria-label="0" id="totalproductos"
                                        value="$0,00" step="any">
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly w-75">
                                <input class="my-5 btn button w-25" type="submit" value="Guardar">
                                <a class="my-5 btn button w-25" type="button" href="index.php?module=pedidos">Cancelar</a>
                            </div>
                        </div>


                    </div>
                </form>
                <?php $gestionPantallaCtr->crearPopUp(new PopUpMdl('grillaProductos', 'Productos', "", BOTONES_POPUP_PRODUCTOS, '')); ?>
            </article>
        </main>
    </body>
    <?php
    echo "<script>cargarGrillaProducto('pedidos', " . $jsonProductosPedido . ")</script>"
        ?>

    </html>
<?php } ?>