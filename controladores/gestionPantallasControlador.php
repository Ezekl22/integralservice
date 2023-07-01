<?php
require_once 'models/GestionPantallasMdl.php';
require_once 'models/GestionPantallasDAO.php';

class GestionPantallasControlador {
    private $GestionPantallasDAO;

    public function __construct() {
        $this->GestionPantallasDAO = new GestionPantallasDAO();
    }

    public function getGestionPantallasDAO() {
        // Obtener la lista de usuarios desde el modelo
        return $this->GestionPantallasDAO;
    }

    public function mostrarOcultarPantallaEditar(int $id): void {
        $gPantallas = $this->GestionPantallasDAO->getGestionPantallasById($id);
        $inUse = $gPantallas['inuse'] == 1? 0 : 1;
        $gestionPantallas = new GestionPantallasMdl($gPantallas, $inUse);
        $this->GestionPantallasDAO->updateGestionPantallas($gestionPantallas);
    }

    public function getGestionPantallasById($id) {
        $gPResult = $this->getGestionPantallasDAO()->getGestionPantallasById($id);
        $gPantallas = new GestionPantallasMdl($gPResult[''])
        return $this->GestionPantallasDAO;
    }


}
