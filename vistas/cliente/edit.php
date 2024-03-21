
<?php 
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $ClienteCtr = new ClienteCtr();
    $cliente = $ClienteCtr->clienteDAO->getClienteById($id);

    if($action == 'edit' && $id != ''){
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editar Cliente</title>
        </head>
        <body>
            <main class="d-flex flex-column align-items-center mt-5 mb-5" id="editCliente">
                <article class="editar__contenedor rounded-4">
                    <form action="index.php?module=clientes&action=edited&id=<?php echo $id?>" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                        <div class="d-flex flex-column align-items-center" id="contenedor">
                            <h2 class="mt-2 text__white">Editar Cliente</h2>
                            <div class="my-3 d-flex flex-row">
                                <div class="input-group input-group-sm mb-3">
                                    <label class="input-group-text" for="nombre" id="inputGroup-sizing-sm">Nombre:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="apellido" id="inputGroup-sizing-sm">Apellido:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" value="<?php echo $cliente['apellido']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="email" id="inputGroup-sizing-sm">Email:</label>
                                    <input type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="email" name="email" value="<?php echo $cliente['email']; ?>" required>
                                </div>
                            </div>
                            <div class="my-3 d-flex flex-row">
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="cuit" id="inputGroup-sizing-sm">Cuit:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="cuit" name="cuit" value="<?php echo $cliente['cuit']; ?>" required>
                                </div>
                                <div class="input-group input-group-sm mb-3 ms-5">
                                    <label class="input-group-text" for="iva" id="inputGroup-sizing-sm">Categoria fiscal:</label>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="categoriafiscal" name="categoriafiscal" value="<?php echo $cliente['categoriafiscal']; ?>" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-evenly w-75">
                                <input class="my-5 btn button w-25" type="submit"  value="Guardar cambios">
                                <a class="my-5 btn button w-25" type="button" href="index.php?module=clientes">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </article>
            </main>
        </body>
        </html>
<?php }?>
