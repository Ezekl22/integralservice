<?php

require_once 'includes/DBConnection.php';

class ProveedorDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function create(ProveedorMdl $proveedor)
    {
        $queries = [
            [
                'query' => 'INSERT INTO proveedores (nombre, categoria_fiscal, direccion, telefono, correo, cuit, saldo) VALUES ',
                'type' => 'INSERT',
                'params' => [
                    [
                        "'" . $proveedor->getNombre() . "'",
                        "'" . $proveedor->getCategoriaFiscal() . "'",
                        "'" . $proveedor->getDireccion() . "'",
                        $proveedor->getTelefono(),
                        "'" . $proveedor->getCorreo() . "'",
                        $proveedor->getCuit(),
                        $proveedor->getSaldo(),
                    ]
                ]
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function update(ProveedorMdl $proveedor)
    {
        $queries = [
            [
                'query' => "UPDATE proveedores SET nombre='" . $proveedor->getNombre() . "', categoria_fiscal='" . $proveedor->getCategoriaFiscal() . "', direccion='" . $proveedor->getDireccion() . "', telefono=" . $proveedor->getTelefono() . ", correo='" . $proveedor->getCorreo() . "', saldo=" . $proveedor->getSaldo() . ", cuit=" . $proveedor->getCuit() . " WHERE idproveedor=" . $proveedor->getId(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function delete($id)
    {
        $queries = [
            [
                'query' => "DELETE FROM proveedores WHERE idproveedor = " . $id,
                'type' => 'DELETE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getProveedorById($id)
    {
        $queries = [
            [
                'query' => "SELECT * FROM proveedores WHERE idproveedor = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $proveedor = UtilidadesDAO::getInstance()->executeQuery($queries);
        return is_array($proveedor) ? $proveedor[0] : $proveedor;
    }

    public function getAllProveedores()
    {
        // Código para obtener todos los proveedors desde la base de datos
        $queries = [
            [
                'query' => "SELECT * FROM proveedores",
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
                    'query' => "SELECT * FROM proveedores WHERE 
                                nombre LIKE '$termino' OR 
                                categoria_fiscal LIKE '$termino' OR 
                                direccion LIKE '$termino' OR 
                                telefono LIKE '$termino' OR 
                                correo LIKE '$termino' OR 
                                cuit LIKE '$termino' OR 
                                saldo LIKE '$termino' OR 
                                fechaCreacion LIKE '$termino' ",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }
}
