<?php

class PresupuestoMdl {
    private $idpresupuesto;
    private $idclient;
    private $nrocomprobante;
    private $estado;
    private $fecha;
    private $puntoventa;
    private $total;

    public function __construct($name, $lastname, $type, $username, $password) {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->type = $type;
        $this->username = $username;
        $this->password = $password;
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

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
