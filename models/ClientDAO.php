<?php

require_once 'includes/DBConnection.php';

class ClientDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createClient(Client $client) {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO clientes (nombre, apellido, email, cuit, categoriafiscal) VALUES (:nombre, :apellido, :email, :cuit, :categoriaFiscal)");
        
        $nombre = $client->getName();
        $apellido = $client->getLastname();
        $email = $client->getEmail();
        $cuit = $client->getCuit();
        $categoriaFiscal = $client->getCategoriaFiscal();
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);
		$stmt->bindParam(":categoriaFiscal", $categoriaFiscal, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    public function update(Client $client) {
        // Código para actualizar un cliente existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE clientes SET nombre=:nombre, apellido=:apellido, email=:email, cuit=:cuit, categoriafiscal=:categoriafiscal WHERE idcliente= :idcliente");
        
        $nombre = $client->getName();
        $apellido = $client->getLastname();
        $email = $client->getEmail();
        $cuit = $client->getCuit();
        $categoriaFiscal = $client->getCategoriaFiscal();
        $id = $client->getId();
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $cuit, PDO::PARAM_STR);
		$stmt->bindParam(":categoriafiscal", $categoriaFiscal, PDO::PARAM_STR);
		$stmt->bindParam(":idcliente",$id , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    public function delete($id) {
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

    public function getClienteById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes WHERE idcliente = ".$id);

        $stmt->execute();
        $retorno = $stmt -> fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function getAllClientes() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes");

        $stmt->execute();
        $retorno = $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }
}
