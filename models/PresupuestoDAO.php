<?php

require_once 'includes/DBConnection.php';
require_once 'models/UtilidadesDAO.php';

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
        $params = [];
        if ($presupuesto->getTipo() == "Venta") {
            for ($i = 0; $i < count($productos); $i++) {
                $param = [
                    '@idpresupuesto',
                    $productos[$i]->getIdProducto(),
                    $productos[$i]->getPreciounit(),
                    $productos[$i]->getCantidad(),
                ];
                array_push($params, $param);
            }

            $queryInsert = "INSERT INTO productospresupuestos (idpresupuesto, idproducto, preciounit, cantidad) 
            VALUES ";
        } elseif ($presupuesto->getTipo() == "Reparacion") {
            $queryInsert = 'INSERT INTO reparaciones (idpresupuesto, modelo, marca, numeroserie, descripcion) VALUES ';
            $param = [
                "'@idpresupuesto'",
                "'" . $reparacion->getModelo() . "'",
                "'" . $reparacion->getMarca() . "'",
                "'" . $reparacion->getNumeroSerie() . "'",
                "'" . $reparacion->getDescripcion() . "'",
            ];
            array_push($params, $param);
        }

        $queries = [
            [
                'query' => 'INSERT INTO presupuestos (idcliente, nrocomprobante, tipo, estado, fecha, puntoventa, total) VALUES ',
                'type' => 'INSERT',
                'params' => [
                    [
                        $presupuesto->getIdCliente(),
                        "'" . $presupuesto->getNroComprobante() . "'",
                        "'" . $presupuesto->getTipo() . "'",
                        "'" . $presupuesto->getEstado() . "'",
                        "'" . date("d-m-Y") . "'",
                        "'" . $presupuesto->getPuntoVenta() . "'",
                        $presupuesto->getTotal(),
                    ]
                ]
            ],
            [
                'query' => 'SET @idpresupuesto = LAST_INSERT_ID(); ',
                'type' => 'SET',
                'params' => [],
            ],
            [
                'query' => $queryInsert,
                'type' => 'INSERT',
                'params' => $params,
            ]

        ];

        $error = UtilidadesDAO::getInstance()->executeQuery($queries);

        return $error != "" ? "Error en la creacion del presupuesto: " . $error : $error;
    }

    private function createProductosPresupuesto(array $productos)
    {
        $params = "";
        for ($i = 0; $i < count($productos); $i++) {
            $param = [
                $productos[$i]->getIdPresupuesto(),
                $productos[$i]->getIdProducto(),
                $productos[$i]->getPreciounit(),
                $productos[$i]->getCantidad(),
            ];
            array_push($params, $param);
        }
        $queries = [
            [
                'query' => "INSERT INTO productospresupuestos (idpresupuesto, idproducto, preciounit, cantidad) VALUES ",
                'type' => 'INSERT',
                'params' => $params,
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updatePresupuesto(PresupuestoMdl $presupuesto)
    {
        $queries = [
            [
                'query' => "UPDATE presupuestos SET 
                            idcliente = " . $presupuesto->getIdCliente() . ", 
                            total=" . $presupuesto->getTotal() . ", 
                            estado= '" . $presupuesto->getEstado() . "' 
                            WHERE idpresupuesto= " . $presupuesto->getIdPresupuesto(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        if (isset($_GET['action']) && $_GET['action'] != "facturar") {
            if ($presupuesto->getTipo() == "Reparacion") {
                $this->updateReparacionPresupuesto($presupuesto->getIdPresupuesto());
            } else {
                $this->updateProductosPresupuesto($presupuesto->getIdPresupuesto(), $presupuesto);
            }
        }

        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updateReparacionPresupuesto(int $idPresupuesto)
    {
        $reparacion = new ReparacionMdl($_POST['modelo'], $_POST['marca'], $_POST['nroserie'], $_POST['descripcion']);
        $queries = [
            [
                'query' => "UPDATE reparaciones SET 
                            modelo = " . $reparacion->getModelo() . ", 
                            marca=" . $reparacion->getMarca() . ", 
                            numeroserie=" . $reparacion->getNumeroSerie() . "
                            descripcion=" . $reparacion->getDescripcion() . "
                            WHERE idpresupuesto= " . $idPresupuesto,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
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
        $queries = [
            [
                'query' => "UPDATE productospresupuestos SET preciounit = CASE" . $queryCasesPrecio .
                    " END, cantidad = CASE" . $queryCasesCantidad .
                    " END WHERE idPresupuesto = " . $productos[0]->getIdPresupuesto() .
                    " AND idProducto IN (" . $queryCasesWhere . ");",
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    private function deleteProductosPresupuesto(int $idPresupuesto, array $productos)
    {
        $placeholders = implode(',', array_fill(0, count($productos), '?'));
        $queries = [
            [
                'query' => "DELETE FROM productospresupuestos WHERE idpresupuesto = ? AND idproducto IN ($placeholders) ",
                'type' => 'DELETE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getNuevoNroComprobante()
    {
        $queries = [
            [
                'query' => "SELECT MAX(idpresupuesto) FROM presupuestos",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries)[0][0];
    }

    public function getPresupuestoById($id)
    {
        $queries = [
            [
                'query' => "SELECT * FROM presupuestos WHERE idPresupuesto = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries)[0];
    }

    public function getAllPresupuestos()
    {
        $queries = [
            [
                'query' => "SELECT * FROM presupuestos",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $queries = [
                [
                    'query' => "SELECT presupuestos.idpresupuesto, 
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
                          OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino'",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }

    public function getProductosPresupuestoById($id)
    {
        $queries = [
            [
                'query' => "SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                            productospresupuestos.cantidad, productos.precioventa, 
                            productospresupuestos.cantidad * productos.precioventa AS total
                            FROM productospresupuestos
                            INNER JOIN productos ON productospresupuestos.idproducto = productos.idproducto
                            WHERE productospresupuestos.idpresupuesto = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getReparacionPresupuestoById($id)
    {
        $queries = [
            [
                'query' => "SELECT modelo, marca, numeroserie, descripcion
                            FROM reparaciones
                            WHERE reparaciones.idpresupuesto = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries)[0];
    }

    public function annul($id)
    {
        $queries = [
            [
                'query' => "UPDATE presupuestos SET estado = 'anulado' WHERE idPresupuesto = " . $id,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }
}