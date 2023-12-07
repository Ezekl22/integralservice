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
                <div class="d-flex w-75 justify-content-end mt-3">
                    <div class="input-group input-group-sm w-25">
                        <input type="text" class="form-control" placeholder="Ingrese su busqueda" aria-label="Recipient's username" aria-describedby="buscar">
                        <input class="btn btn-outline-secondary button" type="button" id="buscar" value="Buscar"></button>
                    </div>
                </div>
                <?php require_once 'vistas/otros/grilla.php' ?>
            </div>
            <?php 
            $action = isset($_GET['action'])?$_GET['action']:'';
            if(($action != 'edit' && $action != 'create') ){ ?>
                <a class="my-5 btn button" type="button" href="index.php?module=usuarios&action=create">Crear nuevo usuario</a>
            <?php } ?>
        </article>
    </main>
</body>
</html>
