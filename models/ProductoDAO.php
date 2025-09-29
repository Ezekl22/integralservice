<?php
require_once 'includes/DBConnection.php';

class ProductoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function update(ProductoMdl $producto)
    {
        $queries = [
            [
                'query' => "UPDATE productos SET 
                            nombre='" . $producto->getNombre() . "', 
                            marca='" . $producto->getMarca() . "', 
                            detalle='" . $producto->getDetalle() . "', 
                            stock=" . $producto->getStock() . ", 
                            tipo='" . $producto->getTipo() . "', 
                            preciocompra=" . $producto->getPrecioCompra() . ",
                            precioventa=" . $producto->getPrecioVenta() . "  
                            WHERE idproducto=" . $producto->getIdProducto(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function create(ProductoMdl $producto)
{
    $queries = [
        [
            'query' => "INSERT INTO productos (nombre, marca, detalle, stock, tipo, preciocompra, precioventa, estado) VALUES ",
            'type' => 'INSERT',
            'params' => [
                [
                    "'" . $producto->getNombre() . "'",
                    "'" . $producto->getMarca() . "'",
                    "'" . $producto->getDetalle() . "'",
                    $producto->getStock(),
                    "'" . $producto->getTipo() . "'",
                    $producto->getPrecioCompra(),
                    $producto->getPrecioVenta(),
                    "'habilitado'",
                ]
            ],
        ]
    ];
    return UtilidadesDAO::getInstance()->executeQuery($queries);
}


    public function getProductoById($id)
    {
        $queries = [
            [
                'query' => "SELECT * FROM productos WHERE idproducto = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $producto = UtilidadesDAO::getInstance()->executeQuery($queries);
        return is_array($producto) ? $producto[0] : $producto;
    }

    public function getProductosById($ids)
    {
        $queries = [
            [
                'query' => "SELECT * FROM productos WHERE idproducto in (" . implode(", ", $ids) . ")",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getAllProductosRepuestos()
    {
        $queries = [
            [
                'query' => "SELECT * FROM productos",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getAllProductos()
    {
        $queries = [
            [
                'query' => "SELECT * FROM productos 
                            WHERE tipo = 'producto'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getAllRepuestos()
    {
        $queries = [
            [
                'query' => "SELECT * FROM productos 
                            WHERE tipo = 'repuesto'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function deshabilitar($id, $action)
    {
        $queries = [
            [
                'query'=> 'UPDATE productos SET estado = "'.$action.'" WHERE idproducto = "'.$id.'"',
                'type'=> 'UPDATE',
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
                    'query' => "SELECT * FROM productos WHERE 
                                nombre LIKE '$termino' OR 
                                marca LIKE '$termino' OR 
                                detalle LIKE '$termino' OR 
                                stock LIKE '$termino' OR 
                                tipo LIKE '$termino' OR 
                                preciocompra LIKE '$termino' OR 
                                precioventa LIKE '$termino'",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }
}
