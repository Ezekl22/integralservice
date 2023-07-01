<?php

require_once 'includes/DBConnection.php';

class GestionPantallasDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function getGestionPantallasById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM gestionpantallas WHERE id = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllGestionPantallas() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM gestionpantallas");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
