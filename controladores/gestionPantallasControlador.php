<?php
require_once 'models/GestionPantallas.php';
require_once 'models/GestionPantallasDAO.php';

class GestionPantallas {
    private $GestionPantallasDAO;

    public function __construct() {
        $this->GestionPantallasDAO = new GestionPantallasDAO();
    }

    public function getGestionPantallasDAO() {
        // Obtener la lista de usuarios desde el modelo
        return $this->GestionPantallasDAO;
    }
}
