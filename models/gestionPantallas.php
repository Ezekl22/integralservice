<?php

class gestionPantallas {
    private $id;
    private $name;
    private $action;
    private $inUse;

    public function __construct($name, $action, $inUse, $id) {
        $this->name = $name;
        $this->action = $action;
        $this->inUse = $inUse;
        $this->id = $id
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

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getInUse() {
        return $this->inUse;
    }

    public function setInUse($inUse) {
        $this->inUse = $inUse;
    }
}
