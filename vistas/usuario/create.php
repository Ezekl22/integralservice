<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h1>Crear Usuario</h1>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="Administrador">Administrador</option>
            <option value="Vendedor">Vendedor</option>
            <option value="Reparador">Reparador</option>
        </select>
        
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        
        <input type="submit" value="Crear">
    </form>

</body>
</html>
