<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <h2>Presupuestos</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo</th>
            <th>Nombre de usuario</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['type']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $user['id']; ?>">Editar</a>
                    <a href="delete.php?id=<?php echo $user['id']; ?>">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    
    <a href="create.php">Crear nuevo usuario</a>

</body>
</html>
