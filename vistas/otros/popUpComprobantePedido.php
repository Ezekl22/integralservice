<div class="modal fade" id="verpedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog pedido-container justify-content-center d-flex" style="max-width:none;">
        <div class="modal-content mx-3 w-90">
            <div class=" modal-header headerPop__background">
                <img src="./assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo"
                    alt="logo de integral Service">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Productos</h2>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 d-flex flex-column align-items-center border border-2">
                    <div class="d-flex flex-row w-100 my-3 align-items-end">
                        <div class="d-flex align-items-start w-30 flex-column ms-5">
                            <h4>
                                <?php echo $nombreProveedor ?>
                            </h4>
                            <p>
                            <?php echo '<b class="me-3">Condición frente al IVA:</b> ' . $proveedor['categoria_fiscal']; ?>
                                <?php
                                $fecha = $pedidoCompra->getFecha();
                                echo '<b class="mx-2">Fecha: </b>' . $fecha;
                                ?>
                            </p>
                        </div>
                        <div class="d-flex align-items-center w-30 flex-column px-5">
                            <div class="h2 border border-2 py-2 px-2 rounded-4">
                                <?php echo $pedidoCompra->getEstado() != "Facturado" ? "X" : "C"; ?>
                            </div>
                            <div class="d-flex w-100 d-flex justify-content-center">
                                <?php if ($pedidoCompra->getEstado() != "Facturado") { ?>
                                    <b class="h3">Pedido </b>
                                <?php } else { ?>
                                    <b class="h3">Factura </b>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-end w-30 flex-column me-5">
                            <div>
                                <div class="d-flex w-100 d-flex align-items-start">
                                    <b class="me-2">Punto de venta: </b> 0001
                                    <?php echo '<b class="mx-2"> Dirección: </b> ' . $proveedor['direccion'] ?>
                                </div>
                                <div class="d-flex w-100 align-items-start">
                                    <?php echo '<b class="mx-2 rounded-2">CUIT: </b> ' . $proveedor['cuit'] ?>
                                    <?php if ($pedidoCompra->getEstado() == "Facturado") {
                                        $nroComprobante = $pedidoCompra->getNroComprobante();
                                        echo '<b class="mx-2">Comp. Nro: </b>' . $nroComprobante;
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row border-bottom border-secondary w-95"></div>
                    <div class="d-flex align-items-start w-100 flex-column mt-3">
                        <?php if ($pedidoCompra->getEstado() != "Facturado") { ?>
                            <div class="w-100 d-flex justify-content-center">
                                Documento no valido como Factura
                            </div>
                        <?php } ?>
                        <h5 class="ms-5">Cliente</h5>
                        <div class="px-5 d-flex w-100 justify-content-between pb-4">
                            <div class="w-30">
                                <b class="me-3">Señor/a(es/as):</b> Integral Service
                            </div>
                            <div class="w-30 d-flex justify-content-center">
                                <b class="me-3">CUIT:</b> 20-38926571-6
                            </div>
                            <div class="w-30 d-flex justify-content-end">
                                <div>
                                    <b class="me-3">Condición frente al IVA:</b> Monotributista
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 px-5">
                        <div class="d-flex flex-row border-bottom border-secondary w-100"></div>
                        <h5 class="mt-3">Detalle</h5>
                        <table class="text-center w-100 border-dark">
                            <tr class="cabecera-grilla__backgrond">
                                <th class="border border-1 border-dark">Nombre</th>
                                <th class="border border-1 border-dark">Marca</th>
                                <th class="border border-1 border-dark">Detalle</th>
                                <th class="border border-1 border-dark">Cantidad</th>
                                <th class="border border-1 border-dark">Precio unitario</th>
                                <th class="border border-1 border-dark">Importe</th>
                            </tr>
                            <?php if (!empty($productosPedido) && is_array($productosPedido)) { ?>
                                <?php foreach ($productosPedido as $productoPedido) { ?>
                                    <tr class="grilla__cuerpo">
                                        <td class="border border-1 border-dark">
                                            <?php echo $productoPedido['nombre']; ?>
                                        </td>
                                        <td class="border border-1 border-dark">
                                            <?php echo $productoPedido['marca']; ?>
                                        </td>
                                        <td class="border border-1 border-dark">
                                            <?php echo $productoPedido['detalle']; ?>
                                        </td>
                                        <td class="border border-1 border-dark">
                                            <?php echo $productoPedido['cantidad']; ?>
                                        </td>
                                        <td class="border border-1 border-dark">
                                            <?php echo '$' . number_format($productoPedido['preciocompra'], 2); ?>
                                        </td>
                                        <td class="border border-1 border-dark">
                                            <?php echo '$' . number_format($productoPedido['total'], 2); ?>
                                        </td>
                                        <?php $total = $total + $productoPedido['total']; ?>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay productos disponibles.</td>
                                </tr>
                            <?php } ?>
                        </table>
                        <div class="d-flex w-100 justify-content-end pt-4">
                            <h4>Total:
                                <?php echo '$' . number_format($total, 2); ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center headerPop__background">
                <button type="button" class="btn button" data-bs-dismiss="modal" onclick="imprimirEnNuevaVentana()">Imprimir</button>
            </div>
        </div>
    </div>
</div>