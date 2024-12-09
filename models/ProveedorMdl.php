<?php

class ProveedorMdl
{
    private $idproveedor;
    private $nombre;
    private $categoria_fiscal;
    private $direccion;
    private $correo;
    private $telefono;
    private $saldo;
    private $cuit;
    private $fechaCreacion;

    public function __construct($nombre, $categoria_fiscal, $direccion, $correo, $telefono, $cuit, $saldo)
    {
        $this->nombre = $nombre;
        $this->categoria_fiscal = $categoria_fiscal;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->saldo = $saldo;
        $this->cuit = $cuit;
    }

    // Getters y setters

    public function getId()
    {
        return $this->idproveedor;
    }

    public function setId($id)
    {
        $this->idproveedor = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getCategoriaFiscal()
    {
        return $this->categoria_fiscal;
    }

    public function setCategoriaFiscal($categoria_fiscal)
    {
        $this->categoria_fiscal = $categoria_fiscal;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getSaldo()
    {
        return $this->saldo;
    }

    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }

    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function getCuit()
    {
        return $this->cuit;
    }

    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }
}
