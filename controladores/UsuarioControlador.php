<?php
require_once 'models/User.php';
require_once 'models/UserDAO.php';

class UserController {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
        $action = isset($_GET['action'])?$_GET['action']:'';
        if($action === "created"){
            $this->create();
        }
        if($action === "deleted"){
            $this->delete($_GET['id']);
        }
        
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $users = $this->getAllUsers();

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
            $user->setId($id);
            $this->userDAO->updateUser($user);
        }

        // Redireccionar a la página principal de usuarios
        //header('Location: index.php?module=usuarios');

    }

    public function getPantallaDelete(){
        require_once 'vistas/usuario/delete.php';
        $this->index();
    }

    public function delete($id) {
        $this->userDAO->deleteUser($id);
    }
}
