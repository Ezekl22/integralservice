<?php
require_once 'includes/DBConnection.php';

class ProductoDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createProducto(ProductoMdl $producto) {
        // Código para crear un nuevo usuario en la base de datos
        // ...
    }

    public function updateProducto(ProductoMdl $producto) {
        // Código para actualizar un usuario existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE productos SET nombre=:nombre, marca=:marca, detalle=:detalle, stock=:stock, tipo = :tipo, preciocompra = :preciocompra, precioventa = :precioventa WHERE id= :id");
        
        $nombre = $producto->getNombre();
        $marca = $producto->getNombre();
        $detalle = $producto->getDetalle();
        $stock = $producto->getStock();
        $tipo = $producto->getTipo();
        $idproducto = $producto->getIdProducto();
        $preciocompra = $producto->getPrecioCompra();
        $precioventa = $producto->getPrecioVenta();
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":marca", $marca, PDO::PARAM_STR);
        $stmt->bindParam(":detalle", $detalle, PDO::PARAM_STR);
		$stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindParam(":preciocompra", $preciocompra, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":precioventa", $precioventa, PDO::PARAM_STR_CHAR);
		$stmt->bindParam(":idproducto",$idproducto , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}
        $stmt->close();
        $stmt = null;
    }

    // public function deleteProducto($id) {
    //     // Código para eliminar un usuario de la base de datos
    //     // ...
    // }

    public function getProductoById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM productos WHERE idproducto = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllProductos() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM productos");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
