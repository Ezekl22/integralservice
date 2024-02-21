<?php

class SesionMdl {
    private $tipoUsuario;

    public function __construct($tipoUsuario) {
        $this->acciones = $tipoUsuario;
    }

    public function getTipoUsuario() {
        return $this->tipoUsuario;
    }
}
