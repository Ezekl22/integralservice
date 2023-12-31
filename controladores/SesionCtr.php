<?php
require_once 'models/User.php';
require_once 'controladores/UsuarioCtr.php';
session_start();
ob_start();

class SesionCtr {
    private $usuarioSesionado;

    public function __construct() {}

    public function verificarInicioSesion(){
        if(isset($_POST['mail']) && isset($_POST['contrasena'])){
            $usuarioCtr = new UsuarioCtr();
            $usuario = $usuarioCtr->getUsuarioByMailContra($_POST['mail'], $_POST['contrasena']);
            if(!empty($usuario)){
                $this->usuarioSesionado = $usuario;
                $this->iniciarSesion($usuario);
            }else{
                $mensajeError ="El mail o contraseña es incorrecto, intentelo nuevamente";
            }
        }
        ob_end_flush();
    }

    private function iniciarSesion($usuario){
        $_SESSION['session'] = $this;
        session_write_close();
        header("Location: index.php?module=menu");
    }

    public function cerrarSesion($gestionPantallasCtr){
        session_unset();
        session_destroy();
        $gestionPantallasCtr->redireccionar("");
    }

    public function getUsuarioSesionado(){
        return $this->usuarioSesionado;
    }
}
