<!-- views/user/delete.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <!-- <h1>Eliminar Usuario</h1>

    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
    
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo</th>
            <th>Nombre de usuario</th>
        </tr>
        <tr>
            <td><?php echo $user['nombre']; ?></td>
            <td><?php echo $user['apellido']; ?></td>
            <td><?php echo $user['tipo']; ?></td>
            <td><?php echo $user['nombre_usuario']; ?></td>
        </tr>
    </table>

    <form action="" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
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
                    <label class="mb-4 mx-5">
                        Esta seguro/a de eliminar este 
                    </label>
                </div>
                <div class="modal-footer d-flex justify-content-center headerPop__background">
                    <button type="button" class="btn button me-5" data-bs-dismiss="modal">Cancelar</button>
                    <a aria-label="Close" class="btn button " href="index.php?module=usuarios&action=deleted&id=<?php echo $_GET['id']?>">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
