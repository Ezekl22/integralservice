
<?php 
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $ClientController = new ClientController();
    $clientt = $ClientController->clientDAO->getClientById($id);
    $ClientController -> update($id);
    $GestionPantallasCtr = new GestionPantallasControlador();
    $GestionPantallasCtr->mostrarOcultarPantallaEditar(1);

    if($GestionPantallasCtr->getGestionPantallasById(1)->getInUse() && $id != ''){
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editar Cliente</title>
        </head>
        <body>
            <main class="d-flex flex-column align-items-center mt-2" style="display: none !important;" id="editCliente">
                <article class="editar__contenedor rounded-4">
                    <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                        <div class="d-flex flex-column align-items-center" id="contenedor">
                            
                            <h2 class="mt-2 text__white">Editar Cliente</h2>
                            <div class="my-3 d-flex flex-row">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="nombre" id="inputGroup-sizing-sm">Nombre:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" value="<?php echo $clientt['nombre']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="apellido" id="inputGroup-sizing-sm">Apellido:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" value="<?php echo $clientt['apellido']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="email" id="inputGroup-sizing-sm">Email:</label>
                                    <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="email" name="email" value="<?php echo $clientt['email']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="cuit" id="inputGroup-sizing-sm">Cuit:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="cuit" name="cuit" value="<?php echo $clientt['cuit']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="iva" id="inputGroup-sizing-sm">Iva:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="iva" name="iva" value="<?php echo $clientt['iva']; ?>" required>
                                </div>
                            </div>
                            <input class="btn button my-2" type="submit"  value="Guardar cambios" onclick="guardarEdicion('editCliente')">
                        </div>
                    </form>
                </article>
            </main>
        </body>
        <script>mostrarOcultarPantallaEditar('editCliente')</script>
        </html>
<?php }?>
