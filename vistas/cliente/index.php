<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Usuarios
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <div class="border w-75 mt-5 mb-5 rounded-4">
                    <table class="grilla__contenedor border-0">
                        <tr class="grilla grilla__cabecera">
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
                                    <a class="icono__contenedor me-3" href="index.php?module=usuarios&action=edit&id=<?php echo $user['id']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                    </a>
                                    <a class="icono__contenedor" href="./vistas/usuario/delete.php?id=<?php echo $user['id']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <a class="my-5 btn button" type="button" href="./vistas/usuario/create.php">Crear nuevo usuario</a>
        </article>
    </main>
</body>
</html>
