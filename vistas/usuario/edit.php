<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
</head>
<body>
    <main class="d-flex flex-column align-items-center mt-2">
        <article class="editar__contenedor rounded-4">
            <form action="" method="POST" class="d-flex flex-column align-items-center border-1 border m-4 rounded-4">
                <div class="d-flex flex-column align-items-center" id="contenedor">
                    <h2 class="mt-2 text__white">Editar Usuario</h2>
                    <div class="my-3 d-flex flex-row">
                        <div class="input-group input-group-sm mb-3">
                            <label class="input-group-text" for="nombre" id="inputGroup-sizing-sm">Nombre:</label>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre" name="nombre" value="<?php echo $user['name']; ?>" required>
                        </div>
                        <div class="input-group input-group-sm mb-3 ms-5">
                            <label class="input-group-text" for="apellido" id="inputGroup-sizing-sm">Apellido:</label>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="apellido" name="apellido" value="<?php echo $user['lastname']; ?>" required>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="input-group input-group-sm mb-3">
                            <label class="input-group-text" for="nombre_usuario" id="inputGroup-sizing-sm">Nombre de usuario:</label>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="nombre_usuario" name="nombre_usuario" value="<?php echo $user['username']; ?>" required>
                        </div>
                        <div class="input-group input-group-sm mb-3 ms-5">
                            <label class="input-group-text" for="contrasena" id="inputGroup-sizing-sm">Contraseña:</label>
                            <input type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="input-group mb-2 ms-5">
                            <label class="input-group-text" for="tipo">Tipo:</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="Administrador" <?php echo ($user['type'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="Vendedor" <?php echo ($user['type'] == 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                                <option value="Reparador" <?php echo ($user['type'] == 'Reparador') ? 'selected' : ''; ?>>Reparador</option>
                            </select>
                        </div>
                    </div>
                    <?php 
                    $id = isset($_GET['id']) ? $_GET['id'] : '';
                    $UserController = new UserController();
                    $UserController -> update($id,); 
                    ?>
                    <input class="btn button my-2" onclick="onClickGuardar()" type="submit" value="Guardar cambios">
                </div>
            </form>
        </article>
    </main>
</body>
</html>
