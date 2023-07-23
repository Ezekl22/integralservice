
<?php 
    $id = isset($_GET['idcliente']) ? $_GET['idcliente'] : '';
    $ClientController = new ClientController();
    $clientt = $this->clientDAO->getClientById($id);
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
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" value="<?php echo $clientt['name']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="apellido" id="inputGroup-sizing-sm">Apellido:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" value="<?php echo $clientt['lastname']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="dni" id="inputGroup-sizing-sm">Dni:</label>
                                    <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="dni" name="dni" value="<?php echo $clientt['dni']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="telefono" id="inputGroup-sizing-sm">Telefono:</label>
                                    <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="telefono" name="telefono" value="<?php echo $clientt['phone']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="direccion" id="inputGroup-sizing-sm">Direccion:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="direccion" name="direccion" value="<?php echo $clientt['adress']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="correo" id="inputGroup-sizing-sm">Correo:</label>
                                    <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="correo" name="correo" value="<?php echo $clientt['mail']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="saldo" id="inputGroup-sizing-sm">Saldo:</label>
                                    <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="saldo" name="saldo" value="<?php echo $clientt['balance']; ?>" required>
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
