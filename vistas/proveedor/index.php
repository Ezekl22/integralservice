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
                    <table class="grilla__contenedor w-95 border-0">
                        <tr class="grilla grilla__cabecera">
                            <th>Nombre</th>
                            <th>Categoria Fiscal</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Saldo</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($proveedores as $proveedor) {
                            $fecha = new DateTime($proveedor['fechaCreacion']) ?>
                            <tr class="grilla__cuerpo">
                                <td>
                                    <?php echo $proveedor['nombre']; ?>
                                </td>
                                <td>
                                    <?php echo $proveedor['categoria_fiscal']; ?>
                                </td>
                                <td>
                                    <?php echo $proveedor['direccion']; ?>
                                </td>
                                <td>
                                    <?php echo $proveedor['telefono']; ?>
                                </td>
                                <td>
                                    <?php echo $proveedor['correo']; ?>
                                </td>
                                <td>
                                    <?php echo $proveedor['saldo']; ?>
                                </td>
                                <td>
                                    <?php echo $fecha->format('Y-m-d'); ?>
                                </td>
                                <td>
                                    <a class="icono__contenedor me-3"
                                        href="index.php?module=proveedores&action=edit&id=<?php echo $proveedor['idproveedor']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                                    </a>
                                    <a class="icono__contenedor"
                                        href="index.php?module=proveedores&action=delete&id=<?php echo $proveedor['idproveedor']; ?>">
                                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg"
                                            alt="icono de eliminar">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <?php
            $action = isset($_GET['action']) ? $_GET['action'] : '';
            if (($action != 'edit' && $action != 'create')) { ?>
                <a class="my-5 btn button" type="button" href="index.php?module=proveedores&action=create">Crear nuevo
                    proveedor</a>
            <?php } ?>
        </article>
    </main>
</body>

</html>