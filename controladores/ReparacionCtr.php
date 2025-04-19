<?php
require_once 'controladores/PresupuestoCtr.php';
require_once 'models/ReparacionDAO.php';

class ReparacionCtr
{
    private $reparacionDAO;
    private $presupuestoCtr;
    private $toastCtr;
    private static $instance = null;

    public function __construct()
    {
        $this->reparacionDAO = new ReparacionDAO();
        $this->presupuestoCtr = new PresupuestoCtr();
        $this->toastCtr = new ToastCtr();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        switch ($action) {
            case 'evaluated':
                if ($status != "success") {
                    $this->evaluar();
                } else {
                    if ($status == "success") {
                        $this->toastCtr->mostrarToast("exito", "Presupuesto evaluado");
                    }
                }
                break;
            case 'repair':
                if ($status != "success") {
                    $this->reparar();
                } else {
                    if ($status == "success") {
                        $this->toastCtr->mostrarToast("exito", "Equipo reparado");
                    }
                }
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
            $status = $this->updateStadoPresupuesto($id);
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

    public function evaluar()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if (empty($id)) {
            $this->toastCtr->mostrarToast("error", "Error al actualizar la reparacion, falta id del presupuesto");
        } else {
            $status = $this->presupuestoCtr->update($id);
            if (empty($status)) {
                $status = $this->updateStadoPresupuesto($id);
                //UtilidadesDAO::getInstance()->showStatus("reparaciones", $status, "evaluated");
            } else {
                $this->toastCtr->mostrarToast("error", "Error al actualizar la reparacion, " . $status);
            }
        }
    }

    public function updateStadoPresupuesto($id)
    {
        $presupuesto = $this->presupuestoCtr->getPresupuestoById($id);
        $estado = "";
        if ($presupuesto->getEstado() == 'pendiente presupuesto') {
            $estado = 'presupuestado';
        } else {
            $estado = 'reparado';
        }
        $status = $this->reparacionDAO->updatEstado($estado, $id);
        return $status;
    }
}

