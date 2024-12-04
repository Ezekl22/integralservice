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
                        "'" . $cliente->getNombre() . "'",
                        "'" . $cliente->getNombre() . "'"
                    ]
                ],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function update(Cliente $cliente)
    {
        // Código para actualizar un cliente existente en la base de datos
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
        $stmt = $this->db->getConnection()->prepare("DELETE FROM clientes WHERE idcliente = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // La eliminación fue exitosa
            return "ok";
        } else {
            // Manejar errores si es necesario
            print_r($this->db->getConnection()->errorInfo());
            return "error";
        }
    }

    public function getClienteById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes WHERE idcliente = " . $id);

        $stmt->execute();
        $retorno = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function getAllClientes()
    {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes");

        $stmt->execute();
        $retorno = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT * FROM clientes WHERE nombre LIKE '$termino' OR apellido LIKE '$termino' OR email LIKE '$termino' OR cuit LIKE '$termino' OR categoriafiscal LIKE '$termino' ";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }

    }
}
