<!-- views/client/delete.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Cliente</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <!-- <h1>Eliminar Cliente</h1>

    <p>¿Estás seguro de que deseas eliminar este cliente?</p>
    
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Dni</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Correo</th>
            <th>Saldo</th>
        </tr>
        <tr>
            <td><?php echo $client['nombre']; ?></td>
            <td><?php echo $client['apellido']; ?></td>
            <td><?php echo $client['email']; ?></td>
            <td><?php echo $client['cuit']; ?></td>
            <td><?php echo $client['iva']; ?></td>
        </tr>
    </table>

    <form action="" method="POST">
        <input type="hidden" name="client_id" value="<?php echo $client['idcliente']; ?>">
        <input type="submit" value="Eliminar">
    </form> -->

    <div class="modal fade show" style="display:block;" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header headerPop__background">
                    <img src="../../assets/img/logo-IntegralService.png" class="shadow rounded-3 me-2 logo" alt="logo de integral Service">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Inicio de sesion</h2>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column">
                    <input type="text" class="mb-4 mx-5" placeholder="cliente">
                    <input type="text" class="mx-5"placeholder="contraseña">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-link btn__recuperarC" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#recuperarCon">
                            recuperar contraseña
                        </button>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center headerPop__background">
                    <button type="button" class="btn button me-5" data-bs-dismiss="modal">Cancelar</button>
                    <a aria-label="Close" class="btn button " href="index.php?module=menu">Ingresar</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
