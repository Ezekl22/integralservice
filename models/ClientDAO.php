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
        $stmt = $this->db->getConnection()->prepare("UPDATE clientes SET name=:name, lastname=:lastname, dni=:dni, phone=:phone, adress=:adress, mail=:mail, balance=:balance WHERE idcliente= :idcliente");
        
        $name = $client->getName();
        $lastname = $client->getLastname();
        $dni = $client->getDni();
        $phone = $client->getPhone();
        $adress = $client->getAdress();
        $mail = $client->getMail();
        $balance = $client->getBalance();
        $id = $client->getId();
        
		$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":dni", $dni, PDO::PARAM_INT);
		$stmt->bindParam(":phone", $phone, PDO::PARAM_INT);
		$stmt->bindParam(":adress", $adress, PDO::PARAM_STR);
		$stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
		$stmt->bindParam(":balance", $balance, PDO::PARAM_STR);
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
        // Código para eliminar un cliente de la base de datos
        // ...
    }

    public function getClientById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes WHERE idcliente = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllClients() {
        // Código para obtener todos los clientes desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM clientes");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
