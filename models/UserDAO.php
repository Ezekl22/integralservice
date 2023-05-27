<?php

require_once 'includes/DBConnection.php';

class UserDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createUser(User $user) {
        // Código para crear un nuevo usuario en la base de datos
        // ...
    }

    public function updateUser(User $user) {
        // Código para actualizar un usuario existente en la base de datos
        // ...
    }

    public function deleteUser($id) {
        // Código para eliminar un usuario de la base de datos
        // ...
    }

    public function getUserById($id) {
        // Código para obtener un usuario por su ID desde la base de datos
        // ...
    }

    public function getAllUsers() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users");

        $stmt->execute();
        return $stmt -> fetchAll();
        //$stmt->close();
//$stmt = null;
    }
}
