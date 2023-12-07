<?php

class GrillaMdl {
    private $acciones;
    private $tipo;
    private $datosCabecera;
    private $datosCuerpo;

    public function __construct($datosCabecera,$datosCuerpo,$acciones,$tipo = 0) {
        $this->acciones = $acciones;
        $this->tipo = $tipo;
        $this->datosCabecera = $datosCabecera;
        $this->datosCuerpo = $datosCuerpo;
    }

    public function getAcciones() {
        return $this->acciones;
    }

    public function setAcciones($acciones) {
        $this->acciones = $acciones;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getDatosCabecera() {
        return $this->datosCabecera;
    }

    public function setDatosCabecera($datosCabecera) {
        $this->datosCabecera = $datosCabecera;
    }

    public function getDatosCuerpo() {
        return $this->datosCuerpo;
    }

    public function setDatosCuerpo($datosCuerpo) {
        $this->datosCuerpo = $datosCuerpo;
    }
}
