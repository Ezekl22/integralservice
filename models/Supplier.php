<?php

class Supplier {
    private $id;
    private $name;
    private $tax_category;
    private $adress;
    private $phone;
    private $mail;
    private $balance;

    public function __construct($name, $tax_category, $adress, $phone, $mail, $balance) {
        $this->name = $name;
        $this->tax_category = $tax_category;
        $this->adress = $adress;
        $this->phone = $phone;
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

    public function getTaxCategory() {
        return $this->tax_category;
    }

    public function setTaxCategory($tax_category) {
        $this->tax_category = $tax_category;
    }

    public function getAdress() {
        return $this->adress;
    }

    public function setAdress($adress) {
        $this->adress = $adress;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
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
