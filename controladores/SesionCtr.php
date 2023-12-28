<?php
require_once 'models/User.php';
require_once 'controladores/UsuarioCtr.php';
session_start();
ob_start();

class SesionCtr {
    private $usuarioSesionado;

    public function __construct() {
        
    }

    public function verificarInicioSesion(){
        $mensajeError ="";
        if(isset($_POST['mail']) && isset($_POST['contrasena'])){
            $usuarioCtr = new UsuarioCtr();
            $usuario = $usuarioCtr->getUsuarioByMailContra($_POST['mail'], $_POST['contrasena']);
            if(!empty($usuario)){
                $this->usuarioSesionado = $usuario;
                $_SESSION['tipoUsuario'] = $usuario->getTipo();
                header("Location: index.php?module=menu");
            }else{
                $mensajeError ="El mail o contraseña es incorrecto, intentelo nuevamente";
            }
        }
    }
}
