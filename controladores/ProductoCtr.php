<?php
require_once 'models/ProductoMdl.php';
require_once 'models/ProductoDAO.php';
require_once 'controladores/ToastCtr.php';

class ProductoCtr
{
    private $productoDAO;
    private static $instance = null;

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
                case 'habilitar':
                case 'deshabilitar':
                    $actionText = $action == 'habilitar' ? 'habilitado' : 'deshabilitado';
                    if ($status != "success") {
                        $this->deshabilitar($id, $action, $actionText);
                    } else if ($status == "success") {
                        $toast->mostrarToast("exito", "Producto " . $actionText);
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

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ProductoCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $termino = isset($_POST['termino']) ? $_POST['termino'] : "";
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRODUCTOS, $action == 'searched' && $termino != "" ? $this->search() : $this->getAllProductos(), [0, 9]);
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

    public function getAllProductosRepuestos()
    {
        $productos = $this->productoDAO->getAllProductosRepuestos();
        if (is_string($productos)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los productos", $productos);
        }
        return $productos;
    }

    public function getAllRepuestos()
    {
        $repuestos = $this->productoDAO->getAllRepuestos();
        if (is_string($repuestos)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los repuestos", $repuestos);
        }
        return $repuestos;
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/producto/create.php';
    }

    public function create()
    {
        if ($_POST["stock"] < 0 || $_POST["preciocompra"] < 0 || $_POST["precioventa"] < 0) {
            UtilidadesDAO::getInstance()->showStatus("productos", "El stock y los precios no pueden ser negativos", "created");
            return;
        }

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
        if ($_POST["stock"] < 0 || $_POST["preciocompra"] < 0 || $_POST["precioventa"] < 0) {
            UtilidadesDAO::getInstance()->showStatus("productos", "El stock y los precios no pueden ser negativos", "edited");
            return;
        }

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
        }
        return $productos;
    }

    public function getPantallaDelete()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete', 'Eliminar Producto', "", BOTONES_POPUP_ELIMINAR, 'index.php?action=delete'));
        $this->index();
    }

    public function deshabilitar($id, $action, $actionText)
    {
        $status = $this->productoDAO->deshabilitar($id, $actionText);
        UtilidadesDAO::getInstance()->showStatus("productos", $status, $action);
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

    public function actualizarStockProducto($id, $cantidad, $operacion)
    {
        $producto = $this->getProductoById($id);
        $stockActual = $producto['stock'];

        if ($operacion == 'sumar') {
            $producto['stock'] = $stockActual + $cantidad;
        } else if ($operacion == 'restar') {
            $producto['stock'] = $stockActual - $cantidad;
        }

        $productoActualizado = new ProductoMdl(
            $producto["nombre"],
            $producto["marca"],
            $producto["detalle"],
            $producto["stock"],
            $producto["tipo"],
            $producto["preciocompra"],
            $producto["precioventa"]
        );
        $productoActualizado->setIdProducto($id);

        $status = $this->productoDAO->update($productoActualizado);
        return $status; // string vacío si está bien, o mensaje de error si falló
    }
}
