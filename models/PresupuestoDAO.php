<?php

require_once 'includes/DBConnection.php';

class PresupuestoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function create(PresupuestoMdl $presupuesto, ReparacionMdl $reparacion = new ReparacionMdl("", "", "", ""))
    {

        $productos = $presupuesto->getProductos();
        $productosValues = "";



        for ($i = 0; $i < count($productos); $i++) {
            $idProducto = $productos[$i]->getIdProducto();
            $preciounit = $productos[$i]->getPreciounit();
            $cantidad = $productos[$i]->getCantidad();
            $separacion = $i != count($productos) - 1 ? ', ' : ';';
            $productosValues = $productosValues . ' (@idpresupuesto, ' . $idProducto . ', ' . $preciounit . ', ' . $cantidad . ')' . $separacion;
        }
        if ($presupuesto->getTipo() == "Venta") {
            $query = "INSERT INTO productospresupuestos (idpresupuesto, idproducto, preciounit, cantidad) 
            VALUES " . $productosValues;
        } elseif ($presupuesto->getTipo() == "Reparacion") {
            $query = 'INSERT INTO reparaciones (idpresupuesto, modelo, marca, numeroserie, descripcion) VALUES ' .
                '(@idpresupuesto, "' . $reparacion->getModelo() . '", "' . $reparacion->getMarca() . '", "' . $reparacion->getNumeroSerie() . '", "' . $reparacion->getDescripcion() . '");';
        }
        $stmt = $this->db->getConnection()->prepare('INSERT INTO presupuestos (idcliente, nrocomprobante, tipo, estado, fecha, puntoventa, total)' .
            'VALUES (:idcliente, :nrocomprobante, :tipo, :estado, :fecha, :puntoventa, :total); ' .
            'SET @idpresupuesto = LAST_INSERT_ID(); ' . $query);
        $idCliente = $presupuesto->getIdCliente();
        $nroComprobante = $presupuesto->getNroComprobante();
        $tipo = $presupuesto->getTipo();
        $estado = $presupuesto->getEstado();
        $fecha = date("d-m-Y");
        $puntoVenta = $presupuesto->getPuntoVenta();
        $total = $presupuesto->getTotal();
        $stmt->bindParam(":idcliente", $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_STR);
        $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":puntoventa", $puntoVenta, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);

        if ($stmt->execute()) {

            return "ok";

        } else {
            $error = $stmt->errorInfo();
        }

        $stmt->closeCursor();
        $stmt = null;

        return $error;
    }

    private function createProductosPresupuesto(array $productos)
    {
        $queryProductos = "";
        for ($i = 0; $i < count($productos); $i++) {

            $separacion = $i == count($productos) - 1 ? ";" : ",";
            $queryProductos = $queryProductos . " (" . $productos[$i]->getIdPresupuesto() . ", "
                . $productos[$i]->getIdProducto() . ", "
                . $productos[$i]->getPreciounit() . ", "
                . $productos[$i]->getCantidad() . ")"
                . $separacion;
        }
        $stmt = $this->db->getConnection()->prepare("INSERT INTO productospresupuestos (idpresupuesto, idproducto, preciounit, cantidad) 
                                                        VALUES " . $queryProductos);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return $stmt->errorInfo();
        }
    }

    public function updatePresupuesto(PresupuestoMdl $presupuesto)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET idcliente=:idcliente,
         total=:total, estado=:estado WHERE idpresupuesto= :idpresupuesto");

        $idCliente = $presupuesto->getIdCliente();
        $total = $presupuesto->getTotal();
        $idPresupuesto = $presupuesto->getIdPresupuesto();
        $estado = $presupuesto->getEstado();

        $stmt->bindParam(":idcliente", $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":idpresupuesto", $idPresupuesto, PDO::PARAM_INT);
        if (isset($_POST['action']) && $_POST['action'] != "facturar") {
            if ($presupuesto->getTipo() == "Reparacion") {
                $this->updateReparacionPresupuesto($idPresupuesto);
            } else {
                $this->updateProductosPresupuesto($idPresupuesto, $presupuesto);
            }
        }

        if ($stmt->execute()) {

            return "ok";

        } else {
            $error = $stmt->errorInfo();
        }
        $stmt->closeCursor();
        $stmt = null;

        return $error;
    }

    public function updateReparacionPresupuesto(int $idPresupuesto)
    {
        $reparacion = new ReparacionMdl($_POST['modelo'], $_POST['marca'], $_POST['nroserie'], $_POST['descripcion']);
        $stmt = $this->db->getConnection()->prepare("UPDATE reparaciones SET modelo=:modelo, marca=:marca,
         numeroserie=:numeroserie, descripcion=:descripcion WHERE idpresupuesto= :idpresupuesto");
        $modelo = $reparacion->getModelo();
        $marca = $reparacion->getMarca();
        $numeroserie = $reparacion->getNumeroSerie();
        $descripcion = $reparacion->getDescripcion();

        $stmt->bindParam(":modelo", $modelo, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":marca", $marca, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":numeroserie", $numeroserie, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":idpresupuesto", $idPresupuesto, PDO::PARAM_INT);

        $valExecute = $stmt->execute();
        $error = $stmt->errorInfo();
        $stmt->closeCursor();
        $stmt = null;
        if ($valExecute) {

            return "ok";

        }
        return $error;
    }

    public function updateProductosPresupuesto(int $idPresupuesto, PresupuestoMdl $presupuesto)
    {
        $productosPresupuestoDB = $this->getProductosPresupuestoById($idPresupuesto);
        $productosPresupuesto = array_map(function ($producto) {
            return new ProductoPresupuestoMdl(
                $producto['idproducto'],
                $producto['precioventa'],
                $producto['cantidad']
            );
        }, $productosPresupuestoDB);

        $productosExistentes = array_map(function (ProductoPresupuestoMdl $producto) {
            return $producto->getIdProducto();
        }, $productosPresupuesto);

        // Obtener los IDs de productos enviados para actualización
        $nuevosProductos = array_map(function ($producto) {
            return $producto->getIdProducto();
        }, $presupuesto->getProductos());


        // Identificar los productos que deben ser eliminados
        $productsToDelete = array_diff($productosExistentes, $nuevosProductos);
        // Eliminar los productos que ya no están asociados

        $productosAInsertar = [];
        $productosAActualizar = [];
        $contadorPAntiguo = 1;

        foreach ($presupuesto->getProductos() as $nuevoProducto) {
            $contadorPNuevo = 1;
            $repetido = false;
            $nuevoProducto->setIdPresupuesto($idPresupuesto);
            foreach ($productosPresupuesto as $antiguoProducto) {
                if ($nuevoProducto->getIdProducto() == $antiguoProducto->getIdProducto()) {
                    $repetido = true;
                    //si el campo de cantidad o de precio unitario es diferente, entonces lo guardo en $productosAActualizar
                    if ($nuevoProducto->getCantidad() != $antiguoProducto->getCantidad() || $nuevoProducto->getPreciounit() != $antiguoProducto->getPreciounit()) {
                        array_push($productosAActualizar, $nuevoProducto);
                    }
                } else {
                    //si recorri todos los productos viejos y no esta en ese array entonces lo agrego a productosAInsertar
                    if ($contadorPNuevo == count($productosPresupuesto) && !$repetido) {
                        array_push($productosAInsertar, $nuevoProducto);
                    }
                }
                if ($contadorPAntiguo == count($productosPresupuesto)) {
                    $nuevoProducto->setIdPresupuesto($idPresupuesto);
                }
                $contadorPNuevo++;
            }
            $contadorPAntiguo++;
        }
        //elimino los productos en la DB que ya no estan en el nuevo presupuesto
        if (!empty($productsToDelete)) {
            $this->deleteProductosPresupuesto($idPresupuesto, $productsToDelete);
        }
        //inserto los productos en la DB que estan en el nuevo presupuesto pero no en el viejo
        if (count($productosAInsertar) > 0) {
            $this->createProductosPresupuesto($productosAInsertar);
        }
        //actualizo los productos que estan en los dos presupuestos y que la columna preciounit o cantidad son diferentes
        if (count($productosAActualizar)) {
            $this->actualizarProductosPresupuesto($productosAActualizar);
        }
        return "ok";
    }

    private function actualizarProductosPresupuesto(array $productos)
    {
        $queryCasesCantidad = "";
        $queryCasesPrecio = "";
        $queryCasesWhere = "";
        $contador = 0;
        foreach ($productos as $producto) {
            $separador = $contador > count($productos) ? ", " : "";
            $queryCasesCantidad = $queryCasesCantidad . " WHEN idProducto = " . $producto->getIdProducto() . " THEN " . $producto->getCantidad();
            $queryCasesPrecio = $queryCasesPrecio . " WHEN idProducto = " . $producto->getIdProducto() . " THEN " . $producto->getPreciounit();
            $queryCasesWhere = $queryCasesWhere . $producto->getIdProducto() . $separador;
            $contador++;
        }

        $stmt = $this->db->getConnection()->prepare("UPDATE productospresupuestos 
                                                        SET preciounit = CASE" . $queryCasesPrecio .
            " END, cantidad = CASE" . $queryCasesCantidad .
            " END WHERE idPresupuesto = " . $productos[0]->getIdPresupuesto() .
            " AND idProducto IN (" . $queryCasesWhere . ");");
        $result = $stmt->execute();
        $error = $stmt->errorInfo();
        $stmt->closeCursor();
        $stmt = null;
        if ($result) {
            return "ok";
        } else {
            print_r($error);
        }

    }

    private function deleteProductosPresupuesto(int $idPresupuesto, array $productos)
    {
        $placeholders = implode(',', array_fill(0, count($productos), '?'));
        $stmt = $this->db->getConnection()->prepare("DELETE FROM productospresupuestos WHERE idpresupuesto = ? AND idproducto IN ($placeholders) ");
        $result = $stmt->execute(array_merge([$idPresupuesto], $productos));
        $error = $stmt->errorInfo();
        $stmt->closeCursor();
        $stmt = null;
        if ($result) {
            return "ok";
        } else {
            print_r($error);
        }

    }

    public function getNuevoNroComprobante()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT MAX(idpresupuesto) FROM presupuestos");

        $stmt->execute();
        $resultado = $stmt->fetchAll()[0][0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function getPresupuestoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;

    }

    public function getAllPresupuestos()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE estado != 'anulado'");

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;

    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT presupuestos.idpresupuesto, 
                      presupuestos.idcliente, presupuestos.nrocomprobante, 
                      presupuestos.tipo, presupuestos.estado,
                      presupuestos.fecha,
                      presupuestos.puntoventa,
                      presupuestos.total
                      FROM presupuestos 
                      INNER JOIN clientes ON presupuestos.idcliente = clientes.idcliente
                      WHERE presupuestos.estado != 'cancelado'
                      AND presupuestos.nrocomprobante LIKE '$termino'
                      OR presupuestos.tipo LIKE '$termino'
                      OR presupuestos.estado LIKE '$termino'
                      OR presupuestos.fecha LIKE '$termino'
                      OR presupuestos.puntoventa LIKE '$termino'
                      OR CAST(presupuestos.total AS CHAR) LIKE '$termino'
                      OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino'";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }
    }

    public function getProductosPresupuestoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                                                     productospresupuestos.cantidad, productos.precioventa, 
                                                     productospresupuestos.cantidad * productos.precioventa AS total
                                                     FROM productospresupuestos
                                                     INNER JOIN productos ON productospresupuestos.idproducto = productos.idproducto
                                                     WHERE productospresupuestos.idpresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function getReparacionPresupuestoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT modelo, marca, numeroserie, descripcion
                                                     FROM reparaciones
                                                     WHERE reparaciones.idpresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function annul($id)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET estado = 'anulado' WHERE idPresupuesto = " . $id);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }
}
