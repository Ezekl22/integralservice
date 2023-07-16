<!-- 
<?php 
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $PresupuestoCtr = new PresupuestoCtr();
    $presupuesto = $this->PresupuestoDAO->getUserById($id);
    $PresupuestoCtr -> update($id);
    $GestionPantallasCtr = new GestionPantallasControlador();
    $GestionPantallasCtr->mostrarOcultarPantallaEditar(4);

    if($GestionPantallasCtr->getGestionPantallasById(4)->getInUse() && $id != ''){
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editar Usuario</title>
        </head>
        <body>
            <main class="d-flex flex-column align-items-center mt-2" style="display: none !important;" id="editUsuario">
                <article class="editar__contenedor rounded-4">
                    <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                        <div class="d-flex flex-column align-items-center" id="contenedor">
                            
                            <h2 class="mt-2 text__white">Editar Presupuesto</h2>
                            <div class="my-3 d-flex flex-row">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="cliente" id="inputGroup-sizing-sm">Cliente:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="cliente" name="cliente" value="<?php echo $PresupuestoCtr->getNombreClienteById($id); ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="apellido" id="inputGroup-sizing-sm">Apellido:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" value="<?php echo $userr['lastname']; ?>" required>
                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="nombre_usuario" id="inputGroup-sizing-sm">Nombre de usuario:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre_usuario" name="nombre_usuario" value="<?php echo $userr['username']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="contrasena" id="inputGroup-sizing-sm">Contraseña:</label>
                                    <input type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="contrasena" name="contrasena" required>
                                </div>
                                <div class="input-group mb-2 ms-5">
                                    <label class="input-group-text" for="tipo">Tipo:</label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="Administrador" <?php echo ($presupuesto['type'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="Vendedor" <?php echo ($presupuesto['type'] == 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                                        <option value="Reparador" <?php echo ($presupuesto['type'] == 'Reparador') ? 'selected' : ''; ?>>Reparador</option>
                                    </select>
                                </div>
                            </div>
                            <input class="btn button my-2" type="submit"  value="Guardar cambios" onclick="guardarEdicion('editUsuario')">
                        </div>
                    </form>
                </article>
            </main>
        </body>
        <script>mostrarOcultarPantallaEditar('editUsuario')</script>
        </html>
<?php }?> -->
