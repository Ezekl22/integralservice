<?php

class ReparacionMdl
{
    private $modelo;
    private $numeroSerie;
    private $descripcion;
    private $total;

    public function __construct($modelo, $numeroSerie, $descripcion, $total)
    {
        $this->modelo = $modelo;
        $this->numeroSerie = $numeroSerie;
        $this->descripcion = $descripcion;
        $this->total = $total;
    }

    // Getters y setters

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }
}