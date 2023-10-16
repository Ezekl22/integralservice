<?php

require_once 'includes/DBConnection.php';

class ClientDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createClient(Client $client) {
        // Código para crear un nuevo cliente en la base de datos
        // ...
    }

    public function updateClient(Client $client) {
        // Código para actualizar un cliente existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE clientes SET name=:name, lastname=:lastname, email=:email, cuit=:cuit, iva=:iva WHERE idcliente= :idcliente");
        
        $name = $client->getName();
        $lastname = $client->getLastname();
        $email = $client->getEmail();
        $cuit = $client->getCuit();
        $iva = $client->getIva();
        $id = $client->getId();
        
		$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->bindParam(":cuit", $cuit, PDO::PARAM_INT);
		$stmt->bindParam(":iva", $iva, PDO::PARAM_STR);
		$stmt->bindParam(":idcliente",$id , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function deleteClient($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM clientes WHERE id = :id");
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
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllClientes() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
