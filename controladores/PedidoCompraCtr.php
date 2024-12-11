<?php
require_once 'models/PedidoCompraMdl.php';
require_once 'models/PedidoCompraDAO.php';
require_once 'models/ProductoPedidoMdl.php';
require_once 'controladores/ProveedorCtr.php';
require_once 'controladores/ProductoCtr.php';
require_once 'controladores/ToastCtr.php';

class PedidoCompraCtr
{
    public $pedidoCompraDAO;
    private $proveedorCtr;
    private $productoCtr;

    private static $instance = null;

    public function __construct()
    {
        $this->pedidoCompraDAO = new PedidoCompraDAO();
        $this->proveedorCtr = ProveedorCtr::getInstance();
        $this->productoCtr = new ProductoCtr();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : "";
        $toast = new ToastCtr();
        if ($status == "error") {
            $description = isset($_GET['description']) ? $_GET['description'] : "";
            $toast->mostrarToast($status, $description);
        }
        switch ($action) {
            case 'create':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->create();
                    }
                }
                break;
            case 'created':
                $toast->mostrarToast("exito", "Pedido creado");
                break;
            case 'annulled':
                if ($status != "success") {
                    $this->annulled($id);
                } else {
                    $toast->mostrarToast("exito", "Pedido anulado");
                }
                break;
            case 'edit':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->update($id);
                    }
                }
                break;
            case 'updated':
                $toast->mostrarToast("exito", "Pedido modificado");
                break;
            // case 'facturar':
            //     if ($status != "success") {
            //         $this->facturar($id);
            //     } else {
            //         $toast->mostrarToast("exito", "Pedido facturado");
            //     }
            //     break;
            case 'searched':
                $this->search();
                break;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PedidoCompraCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $action = $gestionPantallaCtr->getAction();

        $pedidosCompras = $action == "searched" ? $this->search() : $this->pedidoCompraDAO->getAllPedidosCompras();
        if (is_string($pedidosCompras)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer todos los pedidos", $pedidosCompras);
        }

        $pedidoCompraCtr = $this->getInstance();
        $productosPre = [];
        if ($action == 'see') {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $pedidoCompra = $this->getPedidoCompraById($id);
            $proveedor = $this->getProveedorById($pedidoCompra->getIdProveedor());
            $nombreCliente = $proveedor['nombre'];
            $productosPedido = $this->getProductosPedidoById($pedidoCompra->getIdPedidoCompra());
            $total = 0;
        }

        for ($i = 0; $i < count($pedidosCompras); $i++) {
            $pedidosCompras[$i][2] = $this->getNombreProveedorById($pedidosCompras[$i][2]);
        }

        session_start();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PEDIDOS, $pedidosCompras, [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        // Cargar la vista con los datos
        require_once 'vistas/pedidocompra/pedidoCompra.php';
    }

    public function getPantallaCreate()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $this->index();
        require_once 'vistas/pedidocompra/create.php';
    }

    public function create()
    {
        $productos_total = $this->getProductos_Total();
        $estado = 'Pedido';
        $pedidoCompra = new PedidoCompraMdl(
            $this->getNuevoNroComprobante(),
            $_POST['idproveedor'],
            $estado,
            $productos_total->total,
            $productos_total->productos
        );
        $status = $this->pedidoCompraDAO->create($pedidoCompra);

        if ($status == "") {
            header("Location: index.php?module=pedidos&action=created&status=success");
        } else {
            header("Location: index.php?module=pedidos&status=error&description=" . $status);
        }
    }

    private function getProductos_Total()
    {
        $productos = [];
        $precioTotal = 0;
        foreach ($_POST['idproductos'] as $index => $idproducto) {
            $precioUnit = $this->productoCtr->getProductoById($idproducto)['preciocompra'];
            $cantidad = intval($_POST['cantidad'][$index]);
            $producto = new ProductoPedidoMdl($idproducto, $precioUnit, $cantidad);
            $precioTotal += $precioUnit * $cantidad;
            array_push($productos, $producto);
        }
        $productos_Total = new stdClass();
        $productos_Total->productos = $productos;
        $productos_Total->total = $precioTotal;

        return $productos_Total;
    }

    public function getPantallaEdit()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $this->index();
        require_once 'vistas/pedidocompra/edit.php';
    }

    public function getNuevoNroComprobante()
    {
        $nroComprobanteDB = $this->pedidoCompraDAO->getNuevoNroComprobante();
        if (is_string($nroComprobanteDB)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer el numero del comprobante", $nroComprobanteDB);
        }
        $auxNroComprobante = strval($nroComprobanteDB + 1);
        $nroComprobante = str_pad($auxNroComprobante, 10, 0, STR_PAD_LEFT);
        return $nroComprobante;
    }

    public function getNombreProveedorById($id)
    {
        $proveedor = $this->proveedorCtr->getProveedorById($id);
        return $proveedor['nombre'];
    }

    public function getProveedorById($id)
    {
        $proveedor = $this->proveedorCtr->getProveedorById($id);
        return $proveedor;
    }

    public function getProductoById($id)
    {
        $producto = $this->productoCtr->getProductoById($id);
        return $producto;
    }

    public function getProductosPedidoById($id)
    {
        $productoPedido = $this->pedidoCompraDAO->getProductosPedidoById($id);
        if (is_string($productoPedido)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los productos del pedido", $productoPedido);
        }
        return $productoPedido;
    }

    public function update($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["idproveedor"])) {
                $pedidoCompra = $this->getPedidoCompraById($id);
                $pedidoCompra->setIdProveedor($_POST['idproveedor']);
                $productos_total = $this->getProductos_Total();
                $pedidoCompra->setProductos($productos_total->productos);
                $pedidoCompra->setTotal($productos_total->total);
                $status = $this->pedidoCompraDAO->updatePedidoCompra($pedidoCompra);
            }
        }
        if ($status == "") {
            header("Location: index.php?module=pedidos&action=updated&status=success");
        } else {
            header("Location: index.php?module=pedidos&status=error&description=" . $status);
        }
    }

    public function getPedidoCompraById($id)
    {
        $pedidoCompraBD = $this->pedidoCompraDAO->getPedidoCompraById($id);
        if (is_string($pedidoCompraBD)) {
            echo $pedidoCompraBD;
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer el pedido", $pedidoCompraBD);
            exit;
        }
        $productosPedidoBD = $this->getProductosPedidoById($id);

        if (is_string($productosPedidoBD)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al buscar pedido: " . json_encode($pedidoCompraBD));
            return "";
        }
        $pedidoCompra = new PedidoCompraMdl($pedidoCompraBD['nrocomprobante'], $pedidoCompraBD['idproveedor'], $pedidoCompraBD['estado'], $pedidoCompraBD['total'], $productosPedidoBD);
        $pedidoCompra->setIdPedidoCompra($id);
        $pedidoCompra->setFecha($pedidoCompraBD['fecha']);
        return $pedidoCompra;
    }

    public function getPantallaAnnul()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('annul', 'Anular Pedido', "", BOTONES_POPUP_ANULAR, 'index.php?action=annul'));
        $this->index();
    }

    public function annulled($id)
    {
        $pedidoCompra = $this->getPedidoCompraById($id);
        $estado = $pedidoCompra->getEstado();

        if ($estado != 'Recibido' && $estado != 'Facturado' && $estado != 'anulado' && $estado != '')
            $status = $this->pedidoCompraDAO->annul($id);
        if ($status == "") {
            header("Location: index.php?module=pedidos&action=annulled&status=success");
        } else {
            header("Location: index.php?module=pedidos&action=annulled&status=error&description=" . $status);
        }
    }

    public function getAllProveedores()
    {
        return $this->proveedorCtr->getAllProveedores();
    }

    public function getAllProductos()
    {
        return $this->productoCtr->getAllProductos();
    }

    // reveer esta funcion. Para facturar un pedido se tiene que ir a la pantalla de editar, en la cual el usuario puede cargar
    //  la factura y pasar el estado del pedido a facturado

    // public function facturar($id)
    // {
    //     $presupuesto = $this->getPedidoCompraById($id);
    //     $estado = $presupuesto->getEstado();
    //     if ($estado != 'Pendiente presupuesto' && $estado != 'En reparacion' && $estado != '' && $estado != 'Facturado') {
    //         $presupuesto->setEstado('Facturado');
    //         $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
    //         $status = $this->updatePresupuesto($presupuesto);
    //         if ($status == "") {
    //             header("Location: index.php?module=presupuestos&action=facturar&status=success");
    //         } else {
    //             header("Location: index.php?module=presupuestos&status=error&description=" . $status);
    //         }
    //     }
    // }

    private function updatePedidoCompra($pedidoCompra)
    {
        return $this->pedidoCompraDAO->updatePedidoCompra($pedidoCompra);
    }

    public function search()
    {
        $result = $this->pedidoCompraDAO->search();
        if (is_string($result)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al buscar pedidos", $result);
        }
        return $result;
    }

    public function getPedidoCompraDAO()
    {
        return $this->pedidoCompraDAO;
    }
}