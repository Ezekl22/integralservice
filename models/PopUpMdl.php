<?php

class PopUpMdl {
    private $id;
    private $titulo;
    private $datosCuerpo;
    private $botones;
    private $accion;

    public function __construct($id,$titulo,$datosCuerpo = "", $botones = [], $action = "W") {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->datosCuerpo = $datosCuerpo;
        $this->botones = $botones;
        $this->accion = $action;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
       $this->titulo = $titulo;
    }

    public function getDatosCuerpo() {
        return $this->datosCuerpo;
    }

    public function setDatosCuerpo($datosCuerpo) {
       $this->datosCuerpo = $datosCuerpo;
    }

    public function getBotones() {
        return $this->botones;
    }

    public function setBotones(array $Botones) {
       $this->botones = $Botones;
    }

    public function getAccion(){
        return $this->accion;
    }

    public function setAccion($accion){
        $this->accion = $accion;
    }
}
