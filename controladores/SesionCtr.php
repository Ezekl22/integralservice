<?php
require_once 'models/User.php';
session_start();
ob_start();

class SesionCtr {
    private $usuarioSesionado;

    public function __construct() {
        
    }

    public function verificarInicioSesion(){
        if(isset($_POST['mail']) && isset($_POST['contrasena'])){
            $usuarioCtr = new UsuarioCtr;
            $usuario = $usuarioCtr->getUsuarioByMailContra($_POST['mail'], $_POST['contrasena']);
            if(!empty($usuario)){
                echo $usuario->getNombre();
                $_SESSION['tipoUsuario'] = $usuario->getTipo();
                header("Location: index.php?module=menu");
            }
        }
    }
}
