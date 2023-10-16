<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Productos
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <div class="d-flex w-75 justify-content-end mt-3">
                    <div class="input-group input-group-sm w-25">
                        <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                        <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                    </div>
                </div>
                <div class="border w-75 mt-3 mb-5 rounded-4">
                    <table class="grilla__contenedor border-0">
                        <tr class="grilla grilla__cabecera">
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Detalle</th>
                            <th>Stock</th>
                            <th>Tipo</th>
                            <th>Precio de compra</th>
                            <th>Precio de venta</th>
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
                                    <a class="icono__contenedor" href="index.php?module=usuarios&action=delete&id=<?php echo $user['id']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <a class="my-5 btn button" type="button" href="index.php?module=usuarios&action=create">Crear nuevo usuario</a>
        </article>
    </main>
</body>
</html>
