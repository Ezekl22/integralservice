<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h1>Editar Usuario</h1>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $user['nombre']; ?>" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $user['apellido']; ?>" required>
        
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="Administrador" <?php echo ($user['tipo'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
            <option value="Vendedor" <?php echo ($user['tipo'] == 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
            <option value="Reparador" <?php echo ($user['tipo'] == 'Reparador') ? 'selected' : ''; ?>>Reparador</option>
        </select>
        
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo $user['nombre_usuario']; ?>" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        
        <input type="submit" value="Guardar cambios">
    </form>

</body>
</html>
