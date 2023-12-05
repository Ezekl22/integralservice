<div class="border w-75 mt-3 mb-5 rounded-4">
    <table class="grilla__contenedor border-0">
        <tr class="grilla grilla__cabecera">
            <?php 
                //foreach
            ?>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo</th>
            <th>Mail</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr class="grilla__cuerpo">
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['type']; ?></td>
                <td><?php echo $user['mail']; ?></td>
                <td>
                    <a class="icono__contenedor me-3" href="index.php?module=usuarios&action=edit&id=<?php echo $user['id']; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                    </a>
                    <a class="icono__contenedor" href="index.php?module=usuarios&action=delete&id=<?php echo $user['id']; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>