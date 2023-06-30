<?php
require_once 'models/User.php';
require_once 'models/UserDAO.php';

class UserController {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $users = $this->userDAO->getAllUsers();

        // Cargar la vista con los datos
        require_once 'vistas/usuario/index.php';
    }

    public function create() {
        // Mostrar el formulario de creación de usuario
        require_once 'vistas/usuario/create.php';
    }

    public function store($data) {
        // Validar los datos del formulario
        // ...

        // Crear un nuevo usuario en la base de datos
        $user = new User($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
        $this->userDAO->createUser($user);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }

    public function edit() {
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

    public function delete($id) {
        // Eliminar el usuario de la base de datos
        $this->userDAO->deleteUser($id);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }
}
