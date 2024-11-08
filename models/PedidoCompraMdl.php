<?php

class PedidoCompraMdl
{
    private $idpedidocompra;
    private $idproveedor;
    private $fecha;
    private $estado;
    private $total;
    private $nrocomprobante;

    public function __construct($nrocomprobante, $idproveedor, $estado, $total, $fecha)
    {
        $this->nrocomprobante = $nrocomprobante;
        $this->idproveedor = $idproveedor;
        $this->estado = $estado;
        $this->total = $total;
        $this->fecha = $fecha;
    }

    // Getters y setters

    public function getIdPedidoCompra()
    {
        return $this->idpedidocompra;
    }

    public function setIdPedidoCompra($idpedidocompra)
    {
        $this->idpedidocompra = $idpedidocompra;
    }

    public function getIdProveedor()
    {
        return $this->idproveedor;
    }

    public function setIdProveedor($idproveedor)
    {
        $this->idproveedor = $idproveedor;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getNroComprobante()
    {
        return $this->nrocomprobante;
    }

    public function setNroComprobante($nrocomprobante)
    {
        $this->nrocomprobante = $nrocomprobante;
    }
}