<!DOCTYPE html>
<?php
$pedidoCompraCtr = PedidoCompraCtr::getInstance();
$proveedores = $pedidoCompraCtr->getAllProveedores();
$json = json_encode($pedidoCompraCtr->getAllProductos());
echo "<script>const productos = $json;</script>";
?>
<html>

<head>
    <title>Crear pedido de compra</title>
</head>

<body>
    <main class="d-flex flex-column align-items-center mt-2 mb-4 main__flex" id="editPresupuesto">
        <article class="mt-4">
            <h2 class="main__title mb-5">
                Crear pedido de compra
            </h2>
        </article>
        <article class="editar__contenedor rounded-4">
            <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                <div class="d-flex flex-column align-items-center contenedor__mayor" id="contenedor">
                    <div class="my-5 d-flex flex-row w-50">
                        <div class="input-group input-group-sm mx-7">
                            <label class="input-group-text" for="cliente">Proveedor:</label>
                            <select class="form-select" id="proveedor" name="tipo" required>
                                <?php foreach ($proveedores as $proveedor) { ?>
                                    <option value="<?php echo $proveedor['idproveedor'] ?>">
                                        <?php echo $proveedor['nombre'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <h4 class="mt-2 text__white">Productos</h4>
                    <div class="mt-3 d-flex flex-column w-100" id="contProductos">
                    </div>
                    <button class="btn btn-outline-secondary button ms-7 align-self-start"
                        data-bs-target="#grillaProductos" data-bs-toggle="modal" type="button" id="agregar"
                        onclick="mostrarGrillaProductos()">+</button>
                    <div class="text__white d-flex" id="">
                        <div class="input-group input-group-sm mb-3">
                            <label class="input-group-text" for="totalProductos"
                                id="inputGroup-sizing-sm">Total:</label>
                            <input type="text" class="form-control" disabled aria-label="0" id="totalProductos"
                                value="$0,00">
                        </div>
                    </div>
                    <input class="btn button my-2" type="submit" value="Guardar cambios">
                </div>
            </form>
            <div class="modal fade" id="grillaProductos" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog justify-content-center d-flex" style="max-width:none;">
                    <div class="modal-content mx-3" style="width:80vw;">
                        <div class="modal-header headerPop__background">
                            <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo"
                                alt="logo de integral Service">
                            <h2 class="modal-title fs-5" id="exampleModalLabel">Productos</h2>
                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column align-items-center" id="contGrillaProducto">

                        </div>
                        <div class="modal-footer d-flex justify-content-center headerPop__background">
                            <button type="button" class="btn button me-5" onclick="cerrarGrilla('contGrillaProducto')"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="agregarComponenteProducto()" data-bs-dismiss="modal"
                                aria-label="Close" class="btn button ">Seleccionar</button>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
</body>

</html>