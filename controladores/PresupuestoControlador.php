<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/PresupuestoDAO.php';

class PresupuestoCtr {
    private $presupuestoDAO;

    public function __construct() {
        $this->presupuestoDAO = new PresupuestoDAO();
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $presupuestos = $this->presupuestoDAO->getAllPresupuestos();

        // Cargar la vista con los datos
        require_once 'vistas/presupuestos/index.php';
    }

    public function getPantallaCreate(){
        require_once 'vistas/presupuestos/create.php';
    }

    public function create() {
        // Mostrar el formulario de creación de usuario
        require_once 'vistas/presupuestos/create.php';
    }

    public function store($data) {
        // Validar los datos del formulario
        // ...

        // Crear un nuevo usuario en la base de datos
        $presupuesto = new PresupuestoMdl($data['idclient'], $data['nrocomprobante'], $data['estado'], $data['fecha'], $data['puntoventa'], $data['total']);
        $this->presupuestoDAO->createPresupuesto($presupuesto);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }

    public function getPantallaEdit() {
        // Obtener el usuario desde el modelo

        // Mostrar el formulario de edición de usuario con los datos cargados
        require_once 'vistas/presupuestos/edit.php';
        $this->index();
    }

    public function getNombreClienteById($id){
        $cliente = $this->presupuestoDAO->getNombreClienteById($id);
        return $cliente['nombre'].' '.$cliente['apellido'];
    }

    public function update($id) {

        if(isset($_POST["idclient"])){
            $presupuesto = new PresupuestoMdl($_POST["idclient"], $_POST["nrocomprobante"], $_POST["estado"], $_POST["fecha"], $_POST["puntoventa"], $_POST["total"]);
            $presupuesto->setIdPresupuesto($id);
            $this->presupuestoDAO->updatePresupuesto($presupuesto);
        }

        // Redireccionar a la página principal de usuarios
        //header('Location: index.php?module=usuarios');

    }

    public function getPantallaDelete(){
        require_once 'vistas/usuario/delete.php';
        $this->index();
    }

    public function delete($id) {
        // Eliminar el usuario de la base de datos
        $this->presupuestoDAO->deletePresupuesto($id);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }
}
