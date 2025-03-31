<?php
require_once 'controladores/PresupuestoCtr.php';
require_once 'models/ReparacionDAO.php';

class ReparacionCtr
{
    private $reparacionDAO;
    private $presupuestoCtr;
    private static $instance = null;

    public function __construct()
    {
        $this->reparacionDAO = new ReparacionDAO();
        $this->presupuestoCtr = new PresupuestoCtr();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'repair':
                $this->reparar();
                break;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ReparacionCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $reparaciones = $this->getAllReparaciones();
        for ($i = 0; $i < count($reparaciones); $i++) {
            $reparaciones[$i][1] = $this->presupuestoCtr->getNombreClienteById($reparaciones[$i][1]);
        }

        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRESUPUESTOS, $reparaciones, [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        require_once 'vistas/reparaciones/reparacion.php';
    }

    public function getAllReparaciones()
    {
        return $this->reparacionDAO->getAllReparaciones();
    }

    public function reparar()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($id != "") {
            $status = $this->reparacionDAO->reparar($id);
            UtilidadesDAO::getInstance()->showStatus("reparaciones", $status, "repair");
        } else {
            $toast = new ToastCtr();
            $toast->mostrarToast("error al reparar", "falta el id de la reparacion");
            return;
        }
    }

    public function getPantallaEvaluar()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if ($id != "") {
            $this->index();
            require_once 'vistas/reparaciones/evaluate.php';
        } else {
            $toast = new ToastCtr();
            $toast->mostrarToast("error al ingresar a la pantalla de evaluar", "falta el id de la reparacion");
        }

    }
}

