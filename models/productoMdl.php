<?php

class ProductoMdl {
    private $idproducto;
    private $nombre;
    private $marca;
    private $detalle;
    private $stock;
    private $tipo;
    private $preciocompra;
    private $precioventa;

    public function __construct($nombre, $marca, $detalle, $stock, $tipo, $preciocompra, $precioventa) {
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->detalle = $detalle;
        $this->stock = $stock;
        $this->tipo = $tipo;
        $this->preciocompra = $preciocompra;
        $this->precioventa = $precioventa;
    }

    // Getters y setters

    public function getIdProducto() {
        return $this->idproducto;
    }

    public function setIdProducto($id) {
        $this->idproducto = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getDetalle() {
        return $this->detalle;
    }

    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getPrecioCompra() {
        return $this->preciocompra;
    }

    public function setPrecioCompra($preciocompra) {
        $this->preciocompra = $preciocompra;
    }

    public function getPrecioVenta() {
        return $this->precioventa;
    }

    public function setPrecioVenta($precioventa) {
        $this->precioventa = $precioventa;
    }
}
