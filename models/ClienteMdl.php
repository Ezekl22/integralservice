<?php

class Cliente {
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $cuit;
    private $categoriaFiscal;

    public function __construct($nombre, $apellido, $email, $cuit, $categoriaFiscal) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->cuit = $cuit;
        $this->categoriaFiscal = $categoriaFiscal;
    }

    // Getters y setters

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCuit() {
        return $this->cuit;
    }

    public function setCuit($cuit) {
        $this->cuit = $cuit;
    }
    
    public function getCategoriaFiscal() {
        return $this->categoriaFiscal;
    }

    public function setCategoriaFiscal($categoriaFiscal) {
        $this->categoriaFiscal = $categoriaFiscal;
    }
}
