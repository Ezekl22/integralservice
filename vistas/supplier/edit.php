
<?php 
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $SupplierController = new SupplierController();
    $supplierr = $this->supplierDAO->getSupplierById($id);
    $SupplierController -> update($id);
    $GestionPantallasCtr = new GestionPantallasControlador();
    $GestionPantallasCtr->mostrarOcultarPantallaEditar(1);

    if($GestionPantallasCtr->getGestionPantallasById(1)->getInUse() && $id != ''){
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editar Proveedor</title>
        </head>
        <body>
            <main class="d-flex flex-column align-items-center mt-2" style="display: none !important;" id="editProveedor">
                <article class="editar__contenedor rounded-4">
                    <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                        <div class="d-flex flex-column align-items-center" id="contenedor">
                            
                            <h2 class="mt-2 text__white">Editar Proveedor</h2>
                            <div class="my-3 d-flex flex-row">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="nombre" id="inputGroup-sizing-sm">Nombre:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" value="<?php echo $supplierr['name']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="categoria_fiscal" id="inputGroup-sizing-sm">Categoria Fiscal:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="categoria_fiscal" name="categoria_fiscal" value="<?php echo $supplierr['tax_category']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="direccion" id="inputGroup-sizing-sm">Direccion:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="direccion" name="direccion" value="<?php echo $supplierr['adress']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="telefono" id="inputGroup-sizing-sm">Telefono:</label>
                                    <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="telefono" name="telefono" value="<?php echo $supplierr['phone']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="correo" id="inputGroup-sizing-sm">Correo:</label>
                                    <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="correo" name="correo" value="<?php echo $supplierr['mail']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="saldo" id="inputGroup-sizing-sm">Saldo:</label>
                                    <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="saldo" name="saldo" value="<?php echo $supplierr['balance']; ?>" required>
                                </div>
                            </div>
                            <input class="btn button my-2" type="submit"  value="Guardar cambios" onclick="guardarEdicion('editProveedor')">
                        </div>
                    </form>
                </article>
            </main>
        </body>
        <script>mostrarOcultarPantallaEditar('editProveedor')</script>
        </html>
<?php }?>
