<!DOCTYPE html>
<html>

<head>
    <title>Reparaciones</title>
</head>

<body>
    <main class="main__flex">
        <article class="mt-4">
            <h2 class="main__title">
                Reparaciones
            </h2>
        </article>
        <article class="mt-5 d-flex flex-column align-items-center">
            <div class="grilla w-95 d-flex flex-column align-items-center rounded-4">
                <div class="d-flex w-95 justify-content-end mt-3">
                    <form action="index.php?module=reparaciones&action=searched" method="POST"
                        class="input-group input-group-sm w-25" id="formBuscador">
                        <input type="search" id="termino" name="termino" class="form-control"
                            placeholder="Ingrese su busqueda"
                            value="<?php echo isset($_POST['termino']) ? $_POST['termino'] : ""; ?>"
                            aria-label="Recipient's username" aria-describedby="buscar">
                        <input class="btn btn-outline-secondary button" type="submit" id="buscar"
                            value="Buscar"></button>
                    </form>
                </div>
                <?php if ($presupuestos && count($presupuestos) > 0) { ?>
                    <?php $grillaCtr->mostrarGrilla(); ?>
                <?php } else { ?>
                    <h3 class="grilla__mensaje-error">
                        <?php echo $action == 'searched' ? "No se han encontrado registros para esa busqueda" : "No hay reparaciones activas, cree un presupuesto de tipo reparación nuevo" ?>
                    </h3>
                <?php } ?>
            </div>
            <?php
            $action = $gestionPantallaCtr->getModule(); ?>
        </article>
    </main>
    <?php echo $action == 'delete' ? '<script> mostrarVentanaModal("delete"); </script>' : '' ?>
</body>
<script>clickBorrarBusqueda();</script>

</html>