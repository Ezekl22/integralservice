<?php

class User {
    private $id;
    private $name;
    private $lastname;
    private $type;
    private $mail;
    private $password;

    public function __construct($name, $lastname, $type, $mail, $password) {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->type = $type;
        $this->mail = $mail;
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

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
