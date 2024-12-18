<?php

require_once 'includes/DBConnection.php';
require_once 'models/UtilidadesDAO.php';

class PedidoCompraDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function create(PedidoCompraMdl $pedidoCompra)
    {
        $productos = $pedidoCompra->getProductos();
        $params = [];
        for ($i = 0; $i < count($productos); $i++) {
            $param = [
                '@idpedidocompra',
                $productos[$i]->getIdProducto(),
                $productos[$i]->getPreciounit(),
                $productos[$i]->getCantidad(),
            ];
            array_push($params, $param);
        }

        $queryInsert = "INSERT INTO productospedidoscompras (idpedidocompra, idproducto, preciounit, cantidad) 
            VALUES ";

        $queries = [
            [
                'query' => 'INSERT INTO pedidoscompras (nrocomprobante, idproveedor, estado, fecha, total) VALUES ',
                'type' => 'INSERT',
                'params' => [
                    [
                        $pedidoCompra->getNroComprobante(),
                        "'" . $pedidoCompra->getIdProveedor() . "'",
                        "'" . $pedidoCompra->getEstado() . "'",
                        "'" . date("d-m-Y") . "'",
                        $pedidoCompra->getTotal(),
                    ]
                ]
            ],
            [
                'query' => 'SET @idpedidocompra = LAST_INSERT_ID(); ',
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

        return $error != "" ? "Error en la creacion del pedido: " . $error : $error;
    }

    private function createProductosPedido(array $productos)
    {
        $params = [];
        for ($i = 0; $i < count($productos); $i++) {
            $param = [
                $productos[$i]->getIdPedidoCompra(),
                $productos[$i]->getIdProducto(),
                $productos[$i]->getPreciounit(),
                $productos[$i]->getCantidad(),
            ];
            array_push($params, $param);
        }
        $queries = [
            [
                'query' => "INSERT INTO productospedidocompra (idpedidocompra, idproducto, preciounit, cantidad) VALUES ",
                'type' => 'INSERT',
                'params' => $params,
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updatePedidoCompra(PedidoCompraMdl $pedidoCompra)
    {
        $queries = [
            [
                'query' => "UPDATE pedidoscompras SET 
                            idproveedor = " . $pedidoCompra->getIdProveedor() . ", 
                            total=" . $pedidoCompra->getTotal() . ", 
                            estado= '" . $pedidoCompra->getEstado() . "' 
                            WHERE idpedidocompra = " . $pedidoCompra->getIdPedidoCompra(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        if (isset($_GET['action'])) {
            $this->updateProductosPedido($pedidoCompra->getIdPedidoCompra(), $pedidoCompra);
        }

        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }


    public function updateProductosPedido(int $idPedidoCompra, PedidoCompraMdl $pedidoCompra)
    {
        $productosPedidoCompraDB = $this->getProductosPedidoById($idPedidoCompra);
        $productosPedidoCompra = array_map(function ($producto) {
            return new ProductoPedidoMdl(
                $producto['idproducto'],
                $producto['preciocompra'],
                $producto['cantidad']
            );
        }, $productosPedidoCompraDB);

        $productosExistentes = array_map(function (ProductoPedidoMdl $producto) {
            return $producto->getIdProducto();
        }, $productosPedidoCompra);

        // Obtener los IDs de productos enviados para actualización
        $nuevosProductos = array_map(function ($producto) {
            return $producto->getIdProducto();
        }, $pedidoCompra->getProductos());


        // Identificar los productos que deben ser eliminados
        $productsToDelete = array_diff($productosExistentes, $nuevosProductos);
        // Eliminar los productos que ya no están asociados

        $productosAInsertar = [];
        $productosAActualizar = [];
        $contadorPAntiguo = 1;

        foreach ($pedidoCompra->getProductos() as $nuevoProducto) {
            $contadorPNuevo = 1;
            $repetido = false;
            $nuevoProducto->setIdPedidoCompra($idPedidoCompra);
            foreach ($productosPedidoCompra as $antiguoProducto) {
                if ($nuevoProducto->getIdProducto() == $antiguoProducto->getIdProducto()) {
                    $repetido = true;
                    //si el campo de cantidad es diferente, entonces lo guardo en $productosAActualizar
                    if ($nuevoProducto->getCantidad() != $antiguoProducto->getCantidad() || $nuevoProducto->getPreciounit() != $antiguoProducto->getPreciounit()) {
                        array_push($productosAActualizar, $nuevoProducto);
                    }
                } else {
                    //si recorri todos los productos viejos y no esta en ese array entonces lo agrego a productosAInsertar
                    if ($contadorPNuevo == count($productosPedidoCompra) && !$repetido) {
                        array_push($productosAInsertar, $nuevoProducto);
                    }
                }
                if ($contadorPAntiguo == count($productosPedidoCompra)) {
                    $nuevoProducto->setIdPedidoCompra($idPedidoCompra);
                }
                $contadorPNuevo++;
            }
            $contadorPAntiguo++;
        }
        //elimino los productos en la DB que ya no estan en el nuevo pedido
        if (!empty($productsToDelete)) {
            $this->deleteProductosPedido($idPedidoCompra, $productsToDelete);
        }
        //inserto los productos en la DB que estan en el nuevo pedido pero no en el viejo
        if (count($productosAInsertar) > 0) {
            $this->createProductosPedido($productosAInsertar);
        }
        //actualizo los productos que estan en los dos pedidos y que la columna cantidad es diferente
        if (count($productosAActualizar)) {
            $this->actualizarProductosPedido($productosAActualizar);
        }
        return "ok";
    }

    private function actualizarProductosPedido(array $productos)
    {
        $queryCasesCantidad = "";
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
                'query' => "UPDATE productospedidoscompras SET preciounit = CASE" . $queryCasesPrecio .
                    " END, cantidad = CASE" . $queryCasesCantidad .
                    " END WHERE idpedidocompra = " . $productos[0]->getIdPedidoCompra() .
                    " AND idProducto IN (" . $queryCasesWhere . ");",
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    private function deleteProductosPedido(int $idPedidoCompra, array $productos)
    {
        $placeholders = implode(',', array_fill(0, count($productos), '?'));
        $queries = [
            [
                'query' => "DELETE FROM productospedidoscompras WHERE idpedidocompra = ? AND idproducto IN ($placeholders) ",
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
                'query' => "SELECT MAX(idpedidocompra) FROM pedidoscompras",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries)[0][0];
    }

    public function getPedidoCompraById($id)
    {
        $queries = [
            [
                'query' => "SELECT * FROM pedidoscompras WHERE idpedidocompra = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries)[0];
    }

    public function getAllPedidosCompras()
    {
        $queries = [
            [
                'query' => "SELECT * FROM pedidoscompras",
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
                    'query' => "SELECT pedidoscompras.idpedidocompra, 
                          pedidoscompras.nrocomprobante,
                          pedidoscompras.idproveedor,
                          pedidoscompras.estado,
                          pedidoscompras.fecha,
                          pedidoscompras.total
                          FROM pedidoscompras 
                          INNER JOIN proveedores ON pedidoscompras.idproveedor = proveedores.idproveedor
                          WHERE pedidoscompras.estado != 'cancelado'
                          AND pedidoscompras.nrocomprobante LIKE '$termino'
                          OR pedidoscompras.estado LIKE '$termino'
                          OR pedidoscompras.fecha LIKE '$termino'
                          OR CAST(pedidoscompras.total AS CHAR) LIKE '$termino'
                          OR proveedores.nombre LIKE '$termino'",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }

    public function getProductosPedidoById($id)
    {
        $queries = [
            [
                'query' => "SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                            productospedidoscompras.cantidad, productos.preciocompra, 
                            productospedidoscompras.cantidad * productos.preciocompra AS total
                            FROM productospedidoscompras
                            INNER JOIN productos ON productospedidoscompras.idproducto = productos.idproducto
                            WHERE productospedidoscompras.idpedidocompra = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function annul($id)
    {
        $queries = [
            [
                'query' => "UPDATE pedidoscompras SET estado = 'anulado' WHERE idpedidocompra = " . $id,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }
}