<!DOCTYPE html>
<html>

<head>
    <title>Pedidos de Compra</title>
</head>

<body>
    <main class="main__flex">
        <article class="mt-4">
            <h2 class="main__title">
                Pedidos de Compra
            </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">

            <div class="grilla w-95 d-flex flex-column align-items-center rounded-4">

                <div class="d-flex flex-row contenedor__mayor align-items-start mt-4">
                    <div class="d-flex w-100 justify-content-end">
                        <form action="index.php?module=pedidos&action=searched" method="POST"
                            class="input-group input-group-sm w-25" id="formBuscador">
                            <input type="search" id="termino" name="termino" class="form-control"
                                placeholder="Ingrese su busqueda"
                                value="<?php echo isset($_POST['termino']) ? $_POST['termino'] : ""; ?>"
                                aria-label="Recipient's username" aria-describedby="buscar">
                            <input class="btn btn-outline-secondary button" type="submit" id="buscar"
                                value="Buscar"></button>
                        </form>
                    </div>
                </div>
                <?php if ($pedidosCompras && count($pedidosCompras) > 0) { ?>
                    <?php $grillaCtr->mostrarGrilla(); ?>
                <?php } else { ?>
                    <h3 class="grilla__mensaje-error">
                        <?php echo $action == 'searched' ? "No se han encontrado registros para esa busqueda" : "No hay pedidos activos, cree uno nuevo" ?>
                    </h3>
                <?php } ?>
            </div>
            <?php if ($action != 'create') { ?>
                <a class="my-5 btn button" type="button" href="index.php?module=pedidos&action=create">Crear nuevo
                    pedido</a>
            <?php } ?>
        </article>
        <!-------------------------------------------------- Pop up ver pedido ---------------------------------------------->
        <?php if ($action == "see") {
            include_once 'vistas/otros/popUpComprobantePedido.php';
        } ?>
    </main>
</body>
<?php echo $action == 'see' ? '<script> mostrarVentanaModal("verpedido"); </script>' : ''; ?>
<?php echo $action == 'annul' ? '<script> mostrarVentanaModal("annul"); </script>' : ''; ?>
<script>clickBorrarBusqueda();</script>

</html>