<?php

class Client {
    private $id;
    private $name;
    private $lastname;
    private $dni;
    private $phone;
    private $adress;
    private $mail;
    private $balance;

    public function __construct($name, $lastname, $dni, $phone, $adress, $mail, $balance) {
        $this->name = $name;
        $this->lastname = $lastname;
        $this->dni = $dni;
        $this->phone = $phone;
        $this->adress = $adress;
        $this->mail = $mail;
        $this->balance = $balance;
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

    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getAdress() {
        return $this->adress;
    }

    public function setAdress($adress) {
        $this->adress = $adress;
    }
    
    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }
    
    public function getBalance() {
        return $this->balance;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
    }
}
