<?php

require_once 'includes/DBConnection.php';

class ClienteDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function createCliente(Cliente $cliente)
    {
        $queries = [
            [
                'query' => "INSERT INTO clientes (nombre, apellido, email, cuit, categoriafiscal) VALUES ",
                'type' => 'INSERT',
                'params' => [
                    [
                        "'" . $cliente->getNombre() . "'",
                        "'" . $cliente->getApellido() . "'",
                        "'" . $cliente->getEmail() . "'",
                        "'" . $cliente->getCuit() . "'",
                        "'" . $cliente->getCategoriaFiscal() . "'"
                    ]
                ],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function update(Cliente $cliente)
    {
        $queries = [
            [
                'query' => "UPDATE clientes SET 
                            nombre='" . $cliente->getNombre() . "', 
                            apellido='" . $cliente->getApellido() . "', 
                            email='" . $cliente->getEmail() . "', 
                            cuit='" . $cliente->getCuit() . "', 
                            categoriafiscal='" . $cliente->getCategoriaFiscal() . "' 
                            WHERE idcliente=" . $cliente->getId(),
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
                'query' => "DELETE FROM clientes WHERE idcliente = " . $id,
                'type' => 'DELETE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getClienteById($id)
    {
        $queries = [
            [
                'query' => "SELECT * FROM clientes WHERE idcliente = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $cliente = UtilidadesDAO::getInstance()->executeQuery($queries);
        return is_array($cliente) ? $cliente[0] : $cliente;
    }

    public function getAllClientes()
    {
        $queries = [
            [
                'query' => "SELECT * FROM clientes",
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
                    'query' => "SELECT * FROM clientes WHERE 
                                nombre LIKE '$termino' OR 
                                apellido LIKE '$termino' OR 
                                email LIKE '$termino' OR 
                                cuit LIKE '$termino' OR 
                                categoriafiscal LIKE '$termino' ",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }
}
