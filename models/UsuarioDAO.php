<?php

require_once 'includes/DBConnection.php';
require_once 'models/UtilidadesDAO.php';

class UsuarioDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function createUsuario(Usuario $usuario)
    {
        $queries = [
            [
                'query' => "INSERT INTO usuarios (nombre, apellido, mail, contrasena, tipo)
                            VALUES ",
                'type' => 'INSERT',
                'params' => [
                    [
                        "'" . $usuario->getNombre() . "'",
                        "'" . $usuario->getApellido() . "'",
                        "'" . $usuario->getMail() . "'",
                        "'" . $usuario->getContrasena() . "'",
                        "'" . $usuario->getTipo() . "'",
                    ]
                ],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updateUsuario(Usuario $usuario)
    {
        $contrasena = $usuario->getContrasena();
        $txtPassword = $contrasena != '' ? ' contrasena="' . $contrasena . '",' : '';
        $queries = [
            [
                'query' => "UPDATE usuarios SET nombre='" . $usuario->getNombre() . "', 
                            apellido='" . $usuario->getApellido() . "',
                            mail='" . $usuario->getMail() . "'," . $txtPassword . " 
                            tipo='" . $usuario->getTipo() . "' WHERE idusuario=" . $usuario->getIdUsuario(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function deleteUsuario($id)
    {
        $queries = [
            [
                'query' => "DELETE FROM usuarios WHERE idusuario = $id",
                'type' => 'DELETE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getUsuarioById($id)
    {
        $queries = [
            [
                'query' => "SELECT * FROM usuarios WHERE idusuario = " . $id,
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $usuario = UtilidadesDAO::getInstance()->executeQuery($queries);
        if (is_array($usuario)) {
            $usuario = empty($usuario) ? [] : $usuario[0];
        }
        return $usuario;
    }

    public function getAllUsuarios()
    {
        $queries = [
            [
                'query' => "SELECT * FROM usuarios",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function getUsuarioByMailContra($mail, $contrasena)
    {
        $queries = [
            [
                'query' => "SELECT * FROM usuarios WHERE mail = '$mail' AND contrasena = '$contrasena'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $usuario = UtilidadesDAO::getInstance()->executeQuery($queries);
        if (is_array($usuario)) {
            $usuario = empty($usuario) ? [] : $usuario[0];
        }
        return $usuario;
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $queries = [
                [
                    'query' => "SELECT * FROM usuarios WHERE nombre LIKE '$termino' OR apellido LIKE '$termino' OR tipo LIKE '$termino' OR mail LIKE '$termino' ",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }
}
