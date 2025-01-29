<?php

class ProductoPedidoMdl
{
    private $idPedidoCompraProducto;
    private $idPedidoCompra;
    private $idproducto;
    private $precioUnit;
    private $cantidad;

    public function __construct($idproducto, $precioUnit, $cantidad)
    {
        $this->idproducto = $idproducto;
        $this->precioUnit = $precioUnit;
        $this->cantidad = $cantidad;
    }

    // Getters y setters

    public function getIdPedidoCompraProducto()
    {
        return $this->idPedidoCompraProducto;
    }

    public function setIdPedidoCompraProducto($idPedidoCompraProducto)
    {
        $this->idPedidoCompraProducto = $idPedidoCompraProducto;
    }

    public function getIdPedidoCompra()
    {
        return $this->idPedidoCompra;
    }

    public function setIdPedidoCompra($idPedidoCompra)
    {
        $this->idPedidoCompra = $idPedidoCompra;
    }

    public function getIdProducto()
    {
        return $this->idproducto;
    }

    public function setIdProducto($idproducto)
    {
        $this->idproducto = $idproducto;
    }
    public function getPrecioUnit()
    {
        return $this->precioUnit;
    }

    public function setPrecioUnit($precioUnit)
    {
        $this->precioUnit = $precioUnit;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
}