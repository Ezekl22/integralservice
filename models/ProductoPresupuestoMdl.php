<?php

class ProductoPresupuestoMdl {
    private $idpresupuestoproducto;
    private $idpresupuesto;
    private $idproducto;
    private $preciounit;
    private $cantidad;

    public function __construct($idproducto, $preciounit, $cantidad) {
        $this->idproducto = $idproducto;
        $this->preciounit = $preciounit;
        $this->cantidad = $cantidad;
    }

    // Getters y setters

    public function getIdPresupuestoproducto() {
        return $this->idpresupuestoproducto;
    }

    public function setIdPresupuestoproducto($idpresupuestoproducto) {
        $this->idpresupuestoproducto = $idpresupuestoproducto;
    }

    public function getIdPresupuesto() {
        return $this->idpresupuesto;
    }

    public function setIdPresupuesto($idpresupuesto) {
        $this->idpresupuesto = $idpresupuesto;
    }

    public function getIdProducto() {
        return $this->idproducto;
    }

    public function setIdProducto($idproducto) {
        $this->idproducto = $idproducto;
    }

    public function getPreciounit() {
        return $this->preciounit;
    }

    public function setPreciounit($preciounit) {
        $this->preciounit = $preciounit;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
}