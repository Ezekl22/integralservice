<!DOCTYPE html>
<html>
<head>
    <title>Proveedores</title>
</head>
<body>
    <main class="main__flex">
        <article class="mt-4">
                <h2 class="main__title">
                    Proveedores
                </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-75 d-flex flex-column align-items-center rounded-4">
                <div class="border w-75 mt-5 mb-5 rounded-4">
                    <table class="grilla__contenedor border-0">
                        <tr class="grilla grilla__cabecera">
                            <th>Nombre</th>
                            <th>Categoria Fiscal</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Saldo</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($suppliers as $supplier) { ?>
                            <tr class="grilla__cuerpo">
                                <td><?php echo $supplier['name']; ?></td>
                                <td><?php echo $supplier['tax_category']; ?></td>
                                <td><?php echo $supplier['adress']; ?></td>
                                <td><?php echo $supplier['phone']; ?></td>
                                <td><?php echo $supplier['mail']; ?></td>
                                <td><?php echo $supplier['balance']; ?></td>
                                <td>
                                    <a class="icono__contenedor me-3" href="index.php?module=proveedores&action=edit&id=<?php echo $supplier['id']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                    </a>
                                    <a class="icono__contenedor" href="index.php?module=proveedores&action=delete&id=<?php echo $supplier['id']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <a class="my-5 btn button" type="button" href="index.php?module=proveedores&action=create">Crear nuevo proveedor</a>
        </article>
    </main>
</body>
</html>
