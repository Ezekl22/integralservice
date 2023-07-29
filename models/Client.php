<?php

class Client {
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $cuit;
    private $iva;

    public function __construct($name, $lastname, $email, $cuit, $iva) {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->cuit = $cuit;
        $this->iva = $iva;
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
        return $this->name;
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
    
    public function getIva() {
        return $this->iva;
    }

    public function setIva($iva) {
        $this->iva = $iva;
    }
}
