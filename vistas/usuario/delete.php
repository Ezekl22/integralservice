<!-- views/user/delete.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h1>Eliminar Usuario</h1>

    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
    
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo</th>
            <th>Nombre de usuario</th>
        </tr>
        <tr>
            <td><?php echo $user['nombre']; ?></td>
            <td><?php echo $user['apellido']; ?></td>
            <td><?php echo $user['tipo']; ?></td>
            <td><?php echo $user['nombre_usuario']; ?></td>
        </tr>
    </table>

    <form action="" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
        <input type="submit" value="Eliminar">
    </form>

</body>
</html>
