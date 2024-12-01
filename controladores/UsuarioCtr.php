<?php
require_once 'models/UsuarioMdl.php';
require_once 'models/UsuarioDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';
require_once 'controladores/ToastCtr.php';


class UsuarioCtr
{
    private $usuarioDAO;
    private static $instance = null;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $toast = new ToastCtr();
        $status = isset($_GET['status']) ? $_GET['status'] : "";
        if ($status == "error") {
            $description = isset($_GET['description']) ? $_GET['description'] : "";
            ErrorCtr::getInstance()->showError($description, "");
        }
        switch ($action) {
            case 'created':
                //Verifico que el ultimo metodo que se realizo en el server es el post
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //verifico que no se haya guardado previamente un usuario para evitar duplicados
                    if ($status != "success") {
                        $this->create();
                    }
                } else if ($status == "success") {
                    $toast->mostrarToast("exito", "Usuario creado");
                }
                break;
            case 'deleted':
                $status = isset($_GET['status']) ? $_GET['status'] : "";
                echo "hola";
                if ($status != "success") {
                    $this->delete($id);
                } else {
                    $toast->mostrarToast("exito", "Usuario eliminado");
                }
                break;
            case 'edited':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->update($id);
                    }
                } else if ($status == "success") {
                    $toast->mostrarToast("exito", "Usuario editado");
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
            self::$instance = new UsuarioCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $termino = isset($_POST['termino']) ? $_POST['termino'] : "";
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_USUARIOS, $action == 'searched' && $termino != "" ? $this->search() : $this->getAllUsuarios(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);


        // Cargar la vista con los datos
        require_once 'vistas/usuario/usuario.php';
    }

    public function getAllUsuarios()
    {
        return $this->usuarioDAO->getAllUsuarios();
    }

    public function search()
    {
        return $this->usuarioDAO->search();
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/usuario/create.php';
    }

    public function create()
    {
        // Verifica si se han enviado datos por POST
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tipo = $_POST['tipo'];
            $mail = $_POST['mail'];
            $contrasena = $_POST['contrasena'];

            // Crea un nuevo objeto Usuario con los datos del formulario
            $usuario = new Usuario($nombre, $apellido, $tipo, $mail, $contrasena);

            // Llama a la función para crear el usuario en la base de datos
            $status = $this->usuarioDAO->createUsuario($usuario);
            $this->showStatus($status, "created");
        }
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/usuario/edit.php';
    }

    public function update($id)
    {
        if (isset($_POST["nombre"])) {
            $usuario = new Usuario($_POST["nombre"], $_POST["apellido"], $_POST["tipo"], $_POST["mail"], $_POST["contrasena"]);
            $usuario->setIdUsuario($id);
            $status = $this->usuarioDAO->updateUsuario($usuario);
            $this->showStatus($status, "edited");
        }
    }

    public function getPantallaDelete()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete', 'Eliminar Usuario', "", BOTONES_POPUP_ELIMINAR, 'index.php?action=delete'));
        $this->index();
    }

    public function delete($id)
    {
        if (!empty($this->getUsuarioById($id)) && strtoupper($this->getUsuarioById($id)[3]) != "ADMINISTRADOR BASE") {
            $status = $this->usuarioDAO->deleteUsuario($id);
            $this->showStatus($status, "deleted");
        }
    }

    private function showStatus(string $status, string $action = "")
    {
        if ($status == "") {
            header("Location: index.php?module=usuarios"
                . ($action != "" ? "&action=" . $action : $action) . "&status=success");
        } else {
            header("Location: index.php?module=usuarios&status=error&description=" . $status);
        }
    }

    public function getUsuarioById($id)
    {
        $usuario = $this->usuarioDAO->getUsuarioById($id);
        if (is_string($usuario)) {
            ErrorCtr::getInstance()->showError($usuario, "error al traer el usuario");
        }
        return $usuario;

    }

    public function getUsuarioByMailContra($mail, $contrasena)
    {
        $usuarioDB = $this->usuarioDAO->getUsuarioByMailContra($mail, $contrasena);
        if (is_string($usuarioDB)) {
            ErrorCtr::getInstance()->showError($usuarioDB, "error al traer el usuario");
            $usuario = $usuarioDB;
        } else {
            $usuario = count($usuarioDB) > 0 ? new Usuario(
                $usuarioDB['nombre'],
                $usuarioDB['apellido'],
                $usuarioDB['tipo'],
                $usuarioDB['mail']
            ) : $usuarioDB;
        }
        return $usuario;
    }
}
