<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Menu
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <div class="border w-75 mt-5 mb-5">
                    <table class="w-100 grilla__contenedor border-0">
                        <tr class="grilla">
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo</th>
                            <th>Nombre de usuario</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($users as $user) { ?>
                            <tr class="grilla__cuerpo">
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
                </div>
            </div>
            <a class="mt-5" href="./vistas/usuario/create.php">Crear nuevo usuario</a>
        </article>
    </main>
</body>
</html>
