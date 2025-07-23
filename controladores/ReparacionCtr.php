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
            case 'repaired':
                if ($status != "success") {
                    $this->reparar();
                } else {
                    if ($status == "success") {
                        $this->toastCtr->mostrarToast("exito", "Equipo reparado");
                    }
                }
                break;
            case 'searched':
                $this->search();
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
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $presupuestos = $action == "searched" ? $this->search() : $this->getAllReparaciones();
        for ($i = 0; $i < count($presupuestos); $i++) {
            $presupuestos[$i][1] = $this->presupuestoCtr->getNombreClienteById($presupuestos[$i][1]);
        }

        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRESUPUESTOS, $presupuestos, [7, 8]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        require_once 'vistas/reparaciones/reparacion.php';
    }

    public function getAllReparaciones()
    {
        return $this->reparacionDAO->getAllReparaciones();
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

    public function reparar()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $status = $this->updateEstadoPresupuesto($id);
        UtilidadesDAO::getInstance()->showStatus("reparaciones", $status, "repaired");
    }

    public function evaluar()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if (empty($id)) {
            $this->toastCtr->mostrarToast("error", "Error al actualizar la reparacion, falta id del presupuesto");
        } else {
            $status = $this->presupuestoCtr->update($id);
            if (empty($status)) {
                $status = $this->updateEstadoPresupuesto($id);
                if (empty($status)) {
                    $status = $this->updateManoDeObra($id);
                    UtilidadesDAO::getInstance()->showStatus("reparaciones", $status, "evaluated");
                }
            } else {
                $this->toastCtr->mostrarToast("error", "Error al actualizar la reparacion, " . $status);
            }
        }
    }

    private function updateManoDeObra($id)
    {
        $result = "";
        if (isset($_POST['manodeobra'])) {
            $result = $this->reparacionDAO->updateManoDeObra($id, $_POST['manodeobra']);
        }
        return $result;
    }

    public function updateEstadoPresupuesto($id)
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

    public function search()
    {
        $result = $this->reparacionDAO->search();
        if (is_string($result)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al buscar las reparaciones", $result);
        }
        return $result;
    }
}

