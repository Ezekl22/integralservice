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
            <div class="grilla w-95 d-flex flex-column align-items-center rounded-4">
                <div class="d-flex w-95 justify-content-end mt-3">
                    <form action="index.php?module=proveedores&action=searched" method="POST"
                        class="input-group input-group-sm w-30" id="formBuscador">
                        <input type="search" id="termino" name="termino" class="form-control"
                            placeholder="Ingrese su busqueda"
                            value="<?php echo isset($_POST['termino']) ? $_POST['termino'] : ""; ?>"
                            aria-label="Recipient's username" aria-describedby="buscar">
                        <input class="btn btn-outline-secondary button" type="submit" id="buscar"
                            value="Buscar"></button>
                    </form>
                </div>
                <?php $grillaCtr->mostrarGrilla(); ?>
            </div>
            <?php
            $action = isset($_GET['action']) ? $_GET['action'] : '';
            if (($action != 'edit' && $action != 'create')) { ?>
                <a class="my-5 btn button" type="button" href="index.php?module=proveedores&action=create">Crear nuevo
                    proveedor</a>
            <?php } ?>
        </article>
    </main>
    <?php echo $action == 'delete' ? '<script> mostrarVentanaModal("delete"); </script>' : '' ?>
</body>
<script>clickBorrarBusqueda();</script>

</html>