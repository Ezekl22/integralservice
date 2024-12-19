<?php
require_once 'models/ProductoMdl.php';
require_once 'models/ProductoDAO.php';
require_once 'controladores/ToastCtr.php';

class ProductoCtr
{
    private $productoDAO;

    public function __construct()
    {
        $this->productoDAO = new ProductoDAO();
        $module = isset($_GET['module']) ? $_GET['module'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : "";
        $toast = new ToastCtr();
        if ($status == "error") {
            $description = isset($_GET['description']) ? $_GET['description'] : "";
            $toast->mostrarToast($status, "", $description);
        }
        if ($module == 'productos') {
            switch ($action) {
                case 'created':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $status = isset($_GET['status']) ? $_GET['status'] : "";
                        if ($status != "success") {
                            $this->create();
                        }
                    } else {
                        if ($status == "success") {
                            $toast->mostrarToast("exito", "Producto creado");
                        }
                    }
                    break;
                case 'deleted':
                    if ($status != "success") {
                        $this->delete($id);
                    } else if ($status == "success") {
                        $toast->mostrarToast("exito", "Producto eliminado");
                    }
                    break;
                case 'edited':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $status = isset($_GET['status']) ? $_GET['status'] : "";
                        if ($status != "success") {
                            $this->update($id);
                        }
                    } else {
                        if ($status == "success") {
                            $toast->mostrarToast("exito", "Producto editado");
                        }
                    }
                    break;
                case 'searched':
                    $this->search();
                    break;
            }
        }
    }

    public function index()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $termino = isset($_POST['termino']) ? $_POST['termino'] : "";
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRODUCTOS, $action == 'searched' && $termino != "" ? $this->search() : $this->getAllProductos(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        $productos = $this->productoDAO->getAllProductos();
        require_once 'vistas/producto/producto.php';
    }
    public function getProductoById($id)
    {
        $producto = $this->productoDAO->getProductoById($id);
        if (is_string($producto)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer el producto", $producto);
        }
        return $producto;
    }

    public function getAllProductos()
    {
        $productos = $this->productoDAO->getAllProductos();
        if (is_string($productos)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los productos", $productos);
        }
        return $productos;
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/producto/create.php';
    }

    public function create()
    {
        if (isset($_POST['nombre'])) {
            $producto = new ProductoMdl(
                $_POST['nombre'],
                $_POST['marca'],
                $_POST['detalle'],
                $_POST['stock'],
                $_POST['tipo'],
                $_POST['preciocompra'],
                $_POST['precioventa']
            );
            $status = $this->productoDAO->create($producto);
            UtilidadesDAO::getInstance()->showStatus("productos", $status, "created");
        }
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/producto/edit.php';
    }

    public function update($id)
    {
        if (isset($_POST["nombre"])) {
            $producto = new ProductoMdl($_POST["nombre"], $_POST["marca"], $_POST["detalle"], $_POST["stock"], $_POST["tipo"], $_POST["preciocompra"], $_POST["precioventa"]);
            $producto->setIdProducto($id);
            $status = $this->productoDAO->update($producto);
            UtilidadesDAO::getInstance()->showStatus("productos", $status, "edited");
        }
    }

    public function getProductosById($ids)
    {
        $productos = $this->productoDAO->getProductosById($ids);
        if (is_string($productos)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los productos", $productos);
            exit;
        }
        return $productos;
    }

    public function getPantallaDelete()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete', 'Eliminar Producto', "", BOTONES_POPUP_ELIMINAR, 'index.php?action=delete'));
        $this->index();
    }

    public function delete($id)
    {
        $status = $this->productoDAO->delete($id);
        UtilidadesDAO::getInstance()->showStatus("productos", $status, "deleted");
    }

    public function search()
    {
        $resultado = $this->productoDAO->search();
        if (is_string($resultado)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al realizar la busqueda", $resultado);
        }
        return $resultado;
    }

    public function actualizarStockProducto($id, $cantidad){
        $productoPedido = $this->getProductoById($id);
        $stockActual = $productoPedido['stock'];
        $productoPedido['stock'] = $stockActual + $cantidad;
        $producto = new ProductoMdl($productoPedido["nombre"], $productoPedido["marca"], $productoPedido["detalle"], $productoPedido["stock"], $productoPedido["tipo"], $productoPedido["preciocompra"], $productoPedido["precioventa"]);
        $status = $this->productoDAO->update($producto);
        UtilidadesDAO::getInstance()->showStatus("productos", $status, "edited");
    }
}
