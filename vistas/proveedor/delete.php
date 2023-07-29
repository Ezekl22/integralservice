<!-- views/supplier/delete.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Proveedor</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <!-- <h1>Eliminar Proveedor</h1>

    <p>¿Estás seguro de que deseas eliminar este proveedor?</p>
    
    <table>
        <tr>
            <th>Nombre</th>
            <th>Categoria Fiscal</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Saldo</th>
        </tr>
        <tr>
            <td><?php echo $supplier['nombre']; ?></td>
            <td><?php echo $supplier['categoria_fiscal']; ?></td>
            <td><?php echo $supplier['direccion']; ?></td>
            <td><?php echo $supplier['telefono']; ?></td>
            <td><?php echo $supplier['correo']; ?></td>
            <td><?php echo $supplier['saldo']; ?></td>
        </tr>
    </table>

    <form action="" method="POST">
        <input type="hidden" name="supplier_id" value="<?php echo $supplier['id']; ?>">
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
                    <input type="text" class="mb-4 mx-5" placeholder="proveedor">
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
