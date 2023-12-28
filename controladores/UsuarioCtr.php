<?php
require_once 'models/User.php';
require_once 'models/UserDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';

class UsuarioCtr {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
        $action = isset($_GET['action'])?$_GET['action']:'';
        $id = isset($_GET['id'])?$_GET['id']:'';
        switch ($action) {
            case 'created':
                $this->create();
                break;
            case 'deleted':
                $this->delete($id);
                break;
            case 'edited':
                $this->update($id);
                break;
        }
    }

    public function index() {
        $users = $this->getAllUsers();
        $grillaMdl = new GrillaMdl(GRILLA_USUARIOS,$this->getAllUsers(),[0,1]);
        $grillaCtr = new GrillaCtr($grillaMdl);


        // Cargar la vista con los datos
        require_once 'vistas/usuario/index.php';
    }

    public function getAllUsers(){
        return $this->userDAO->getAllUsers();
    }

    public function getPantallaCreate(){
        $this->index();
        require_once 'vistas/usuario/create.php';
    }

    public function create() {
        // Verifica si se han enviado datos por POST
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tipo = $_POST['tipo'];
            $mail = $_POST['mail'];
            $contrasena = $_POST['contrasena'];
    
            // Crea un nuevo objeto User con los datos del formulario
            $user = new User($nombre, $apellido, $tipo, $mail, $contrasena);
    
            // Llama a la función para crear el usuario en la base de datos
            $this->userDAO->createUser($user);
        }
    }

    public function getPantallaEdit() {
        $this->index();
        require_once 'vistas/usuario/edit.php';
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $user = new User($_POST["nombre"], $_POST["apellido"], $_POST["tipo"], $_POST["mail"], $_POST["contrasena"]);
            $user->setIdUsuario($id);
            $this->userDAO->updateUser($user);
        }
    }

    public function getPantallaDelete(){
        require_once 'vistas/usuario/delete.php';
        $this->index();
    }

    public function delete($id) {
        $this->userDAO->deleteUser($id);
    }

    public function getUsuarioByMailContra($mail,$contrasena){
        $usuarioDB = $this->userDAO->getUsuarioByMailContra($mail,$contrasena);

        $usuario = count($usuarioDB) > 0? new User($usuarioDB['nombre'], $usuarioDB['apellido'],$usuarioDB['tipo'],$usuarioDB['mail']) : $usuarioDB;
        return $usuario;
    }
}
