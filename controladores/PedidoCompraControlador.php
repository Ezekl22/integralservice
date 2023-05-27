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
        require_once 'views/user/index.php';
    }

    public function create() {
        // Mostrar el formulario de creación de usuario
        require_once 'views/user/create.php';
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

    public function edit($id) {
        // Obtener el usuario desde el modelo
        $user = $this->userDAO->getUserById($id);

        // Mostrar el formulario de edición de usuario con los datos cargados
        require_once 'views/user/edit.php';
    }

    public function update($id, $data) {
        // Validar los datos del formulario
        // ...

        // Actualizar el usuario en la base de datos
        $user = new User($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
        $user->setId($id);
        $this->userDAO->updateUser($user);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }

    public function delete($id) {
        // Eliminar el usuario de la base de datos
        $this->userDAO->deleteUser($id);

        // Redireccionar a la página principal de usuarios
        header('Location: index.php?action=index');
    }
}
