<?php require_once 'controladores/GrillaCtr.php';
$grillaCtr = new GrillaCtr;?>
<div class="border w-75 mt-3 mb-5 rounded-4">
    <table class="grilla__contenedor border-0">
        <tr class="grilla grilla__cabecera">
            <?php 
                foreach ($grillaCtr->getDatosCabecera() as $datoCabecera) {
                   echo "<th>$datoCabecera</th>";
                }
            ?>
            <th>Acciones</th>
        </tr>
        <?php foreach ($grillaCtr->getDatosCuerpo() as $datoCuerpo) { ?>
            <tr class="grilla__cuerpo">
            <?php foreach ($grillaCtr->getDatosCabecera() as $datoCabecera) { 
                    echo '<td>'.$datoCuerpo[strtolower($datoCabecera)].'</td>';
                }?>
                <td>
                    <a class="icono__contenedor me-3" href="index.php?module=usuarios&action=edit&id=<?php echo $datoCuerpo[0]; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoEditar.png" alt="icono de editar">
                    </a>
                    <a class="icono__contenedor" href="index.php?module=usuarios&action=delete&id=<?php echo $datoCuerpo[0]; ?>">
                        <img class="icono__imagen" src="./assets/img/iconoEliminar.svg" alt="icono de eliminar">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>