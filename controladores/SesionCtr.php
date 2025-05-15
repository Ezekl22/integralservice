<?php
require_once 'models/UsuarioMdl.php';
require_once 'controladores/UsuarioCtr.php';
require_once 'controladores/ToastCtr.php';

ob_start();

class SesionCtr
{
    private $usuarioSesionado;
    private $gestionPantallaCtr;

    public function __construct()
    {
    }

    public function verificarInicioSesion($gestionPantallaCtr)
    {
        $mensajeError = "";
        if (isset($_POST['mail']) && isset($_POST['contrasena'])) {
            $usuarioCtr = UsuarioCtr::getInstance();
            $usuario = $usuarioCtr->getUsuarioByMailContra($_POST['mail'], $_POST['contrasena']);
            if (!empty($usuario) && !is_string($usuario)) {
                $this->usuarioSesionado = $usuario;
                $this->gestionPantallaCtr = $gestionPantallaCtr;
                $this->iniciarSesion();
            } else {
                $toast = new ToastCtr();
                $toast->mostrarToast("error", "El usuario o contraseña es incorrecto");
            }
        }
        ob_end_flush();
    }

    private function iniciarSesion()
    {
        session_start();
        $_SESSION['session'] = $this;
        session_write_close();
        header("Location: index.php?module=menu");
    }

    public function cerrarSesion($gestionPantallasCtr)
    {
        session_start();
        session_unset();
        session_destroy();
        $gestionPantallasCtr->redireccionar("");
    }

    public function getUsuarioSesionado()
    {
        return $this->usuarioSesionado;
    }

    public function getGestionPantallaCtr()
    {
        return $this->gestionPantallaCtr;
    }
}
