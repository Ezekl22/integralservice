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
        require_once 'vistas/usuario/create.php';
    }

    public function create() {
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
        $mail = isset($_POST['mail']) ? $_POST['mail'] : '';
        $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
        $user = new User($nombre, $apellido, $tipo, $mail, $contrasena);
        $this->userDAO->createUser($user);

    }

    public function store($data) {
        // Validar los datos del formulario
        // ...

        // Crear un nuevo usuario en la base de datos
        $user = new User($data['name'], $data['lastname'], $data['type'], $data['mail'], $data['password']);
        $this->userDAO->createUser($user);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }

    public function getPantallaEdit() {
        // Obtener el usuario desde el modelo

        // Mostrar el formulario de edición de usuario con los datos cargados
        require_once 'vistas/usuario/edit.php';
        $this->index();
    }

    public function update($id) {

        if(isset($_POST["nombre"])){
            $user = new User($_POST["nombre"], $_POST["apellido"], $_POST["tipo"], $_POST["nombre_usuario"], $_POST["contrasena"]);
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
        // Eliminar el usuario de la base de datos
        $this->userDAO->deleteUser($id);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }
}
