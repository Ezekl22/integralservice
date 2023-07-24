<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Clientes
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
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Cuit</th>
                            <th>Iva</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($clients as $client) { ?>
                            <tr class="grilla__cuerpo">
                                <td><?php echo $client['nombre']; ?></td>
                                <td><?php echo $client['apellido']; ?></td>
                                <td><?php echo $client['email']; ?></td>
                                <td><?php echo $client['cuit']; ?></td>
                                <td><?php echo $client['iva']; ?></td>
                                <td>
                                    <a class="icono__contenedor me-3" href="index.php?module=clientes&action=edit&id=<?php echo $client['idcliente']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                    </a>
                                    <a class="icono__contenedor" href="index.php?module=clientes&action=delete&id=<?php echo $client['idcliente']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <a class="my-5 btn button" type="button" href="index.php?module=clientes&action=create">Crear nuevo cliente</a>
        </article>
    </main>
</body>
</html>
