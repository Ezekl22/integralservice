<?php

class Client {
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $cuit;
    private $categoriaFiscal;

    public function __construct($name, $lastname, $email, $cuit, $categoriaFiscal) {
        $this->name = $name;
        $this->lastname = $lastname;
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

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
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
