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

    public function create(PresupuestoMdl $presupuesto, ReparacionMdl $reparacion = null)
    {
        $reparacion == null ? $reparacion = new ReparacionMdl("", "", "", "") : $reparacion;

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
                '@idpresupuesto',
                "'" . $reparacion->getModelo() . "'",
                "'" . $reparacion->getMarca() . "'",
                "'" . $reparacion->getNumeroSerie() . "'",
                "'" . $reparacion->getDescripcion() . "'",
            ];
            array_push($params, $param);
        }

        $idestadopresupuesto = $this->getIdEstadoPresupuesto($presupuesto->getEstado());

        $queries = [
            [
                'query' => 'INSERT INTO presupuestos (idcliente, nrocomprobante, tipo, idestadopresupuesto, fecha, puntoventa, total) VALUES ',
                'type' => 'INSERT',
                'params' => [
                    [
                        $presupuesto->getIdCliente(),
                        "'" . $presupuesto->getNroComprobante() . "'",
                        "'" . $presupuesto->getTipo() . "'",
                        $idestadopresupuesto,
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

    private function getIdEstadoPresupuesto($estado)
    {
        $queries = [
            [
                'query' => "SELECT idestadopresupuesto FROM estadopresupuesto WHERE nombre = '" . $estado . "'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $result = UtilidadesDAO::getInstance()->executeQuery($queries);
        return count($result) > 0 ? $result[0]['idestadopresupuesto'] : null;
    }

    private function createProductosPresupuesto(array $productos)
    {
        $params = [];
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
        $idEstadoPresupuesto = $this->getIdEstadoPresupuesto($presupuesto->getEstado());
        $queries = [
            [
                'query' => "UPDATE presupuestos SET 
                            idcliente = " . $presupuesto->getIdCliente() . ", 
                            nrocomprobante='" . $presupuesto->getNroComprobante() . "', 
                            total=" . $presupuesto->getTotal() . ", 
                            idEstadoPresupuesto = '" . $idEstadoPresupuesto . "' 
                            WHERE idpresupuesto= " . $presupuesto->getIdPresupuesto(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        if (isset($_GET['action']) && $_GET['action'] != "facturar" && $_GET['action'] != "cambiarestado") {
            if (isset($_POST['idproductos'])) {
                $this->updateProductosPresupuesto($presupuesto->getIdPresupuesto(), $presupuesto);
            } else {
                $this->updateReparacionPresupuesto($presupuesto->getIdPresupuesto());
            }
        }
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updateReparacionPresupuesto(int $idPresupuesto)
    {
        $reparacion = new ReparacionMdl(
            $_POST['modelo'] ?? '', 
            $_POST['marca'] ?? '', 
            $_POST['nroserie'] ?? '', 
            $_POST['descripcion'] ?? ''
        );
        
        // Escapar valores para evitar errores SQL
        $modelo = addslashes($reparacion->getModelo());
        $marca = addslashes($reparacion->getMarca());
        $numeroSerie = addslashes($reparacion->getNumeroSerie());
        $descripcion = addslashes($reparacion->getDescripcion());
        
        $queries = [
            [
                'query' => "UPDATE reparaciones SET 
                            modelo = '" . $modelo . "', 
                            marca = '" . $marca . "', 
                            numeroserie = '" . $numeroSerie . "', 
                            descripcion = '" . $descripcion . "' 
                            WHERE idpresupuesto = " . $idPresupuesto,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updateProductosPresupuesto(int $idPresupuesto, PresupuestoMdl $presupuesto)
    {
        $productosPresupuestoDB = $this->getProductosPresupuestoById($idPresupuesto);
        $productosPresupuesto = count($productosPresupuestoDB) > 0 ? array_map(function ($producto) {
            return new ProductoPresupuestoMdl(
                $producto['idproducto'],
                $producto['precioventa'],
                $producto['cantidad']
            );
        }, $productosPresupuestoDB) : [];

        $productosAInsertar = [];

        if (count($productosPresupuesto) > 0) {
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

            $contadorPAntiguo = 1;
        }

        $productosAActualizar = [];
        foreach ($presupuesto->getProductos() as $nuevoProducto) {
            $contadorPNuevo = 1;
            $repetido = false;
            $nuevoProducto->setIdPresupuesto($idPresupuesto);
            if (count($productosPresupuesto) > 0) {
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
            } else {
                array_push($productosAInsertar, $nuevoProducto);
            }
        }
        //elimino los productos en la DB que ya no estan en el nuevo presupuesto
        if (!empty($productsToDelete)) {
            $this->deleteProductosPresupuesto($idPresupuesto, $productsToDelete);
        }

        //actualizo los productos que estan en los dos presupuestos y que la columna preciounit o cantidad son diferentes
        if (count($productosAActualizar)) {
            $this->actualizarProductosPresupuesto($productosAActualizar);
        }

        //inserto los productos en la DB que estan en el nuevo presupuesto pero no en el viejo
        if (count($productosAInsertar) > 0) {
            $this->createProductosPresupuesto($productosAInsertar);
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
        $placeholders = implode(',', $productos);
        
        $queries = [
            [
                'query' => "DELETE FROM productospresupuestos WHERE idpresupuesto = $idPresupuesto AND idproducto IN ($placeholders) ",
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
                'query' => "SELECT presupuestos.idpresupuesto, presupuestos.idcliente, presupuestos.nrocomprobante, presupuestos.tipo, estadopresupuesto.nombre as estado, presupuestos.fecha, presupuestos.puntoventa, presupuestos.total FROM presupuestos
                 INNER JOIN estadopresupuesto ON presupuestos.idestadopresupuesto = estadopresupuesto.idestadopresupuesto
                 WHERE idPresupuesto = " . $id,
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
                'query' => "SELECT presupuestos.idpresupuesto, presupuestos.idcliente, presupuestos.nrocomprobante, presupuestos.tipo, estadopresupuesto.nombre as estado, presupuestos.fecha, presupuestos.puntoventa, presupuestos.total FROM presupuestos
                 INNER JOIN estadopresupuesto ON presupuestos.idestadopresupuesto = estadopresupuesto.idestadopresupuesto",
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
                                presupuestos.idcliente, 
                                presupuestos.nrocomprobante, 
                                presupuestos.tipo, 
                                estadopresupuesto.nombre as estado, 
                                presupuestos.fecha, 
                                presupuestos.puntoventa, 
                                presupuestos.total
                                FROM presupuestos 
                                INNER JOIN estadopresupuesto 
                                ON presupuestos.idestadopresupuesto = estadopresupuesto.idestadopresupuesto
                                INNER JOIN clientes 
                                ON presupuestos.idcliente = clientes.idcliente
                                WHERE presupuestos.nrocomprobante LIKE '$termino'
                                OR presupuestos.tipo LIKE '$termino'
                                OR estadopresupuesto.nombre LIKE '$termino'
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
                'query' => "SELECT modelo, marca, numeroserie, descripcion, manodeobra
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
        $idEstadoPresupuesto = $this->getIdEstadoPresupuesto('anulado');
        $queries = [
            [
                'query' => "UPDATE presupuestos SET idestadopresupuesto = ". $idEstadoPresupuesto ." WHERE idPresupuesto = " . $id,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }
}
