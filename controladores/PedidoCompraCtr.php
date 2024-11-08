<?php
require_once 'models/PedidoCompraMdl.php';
require_once 'models/PedidoCompraDAO.php';
require_once 'controladores/ProveedorCtr.php';
require_once 'controladores/ProductoCtr.php';

class PedidoCompraCtr
{
    private $pedidocompraDAO;
    private $proveedorCtr;
    private $productoCtr;
    public $idPedidoSeleccionado;
    public $action;
    private $module;
    public $pedidoSeleccionado;
    private static $instance = null;

    public function __construct()
    {
        $this->proveedorCtr = new ProveedorCtr();
        $this->productoCtr = new ProductoCtr();
        // $this->idPedidoSeleccionado = isset($_GET['id']) ? $_GET['id'] : '';
        // $this->action = isset($_GET['action']) ? $_GET['action'] : '';
        // $this->module = isset($_GET['module']) ? $_GET['module'] : '';
        // // hago este codigo para que solo se utilice en pedidos de compra para la pantalla de editar
        // $this->pedidoSeleccionado = ($this->idPedidoSeleccionado && $this->module == "pedidos") ? $this->pedidocompraDAO->getPedidoCompraById($this->idPedidoSeleccionado) : "";
        $this->pedidocompraDAO = new PedidoCompraDAO();
        $module = isset($_GET['module']) ? $_GET['module'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($module == 'pedidos') {
            switch ($action) {
                case 'created':
                    $this->create();
                    break;
                case 'annulled':
                    $this->annul($id);
                    break;
                case 'edited':
                    $this->update($id);
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
            self::$instance = new PedidoCompraCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $action = $gestionPantallaCtr->getAction();

        $pedidosCompras = $action == "searched" ? $this->search() : $this->pedidocompraDAO->getAllPedidosCompras();

        $pedidoCompraCtr = $this->getInstance();
        if ($action == 'see') {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $pedidoCompra = $this->getPedidoCompraById($id);
            $proveedor = $this->getProveedorById($pedidoCompra->getIdProveedor());
            $nombreProveedor = $proveedor['nombre'];
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

    public function getAllPedidosCompras()
    {
        return $this->pedidocompraDAO->getAllPedidosCompras();
    }

    public function create()
    {
        if (isset($_POST['nrocomprobante'])) {
            $nrocomprobante = $_POST['nrocomprobante'];
            $idproveedor = $_POST['idproveedor'];
            $estado = $_POST['estado'];
            $total = $_POST['total'];
            $fecha = $_POST['fecha'];

            $pedidocompra = new PedidoCompraMdl($nrocomprobante, $idproveedor, $estado, $total, fecha: $fecha);

            $this->pedidocompraDAO->create($pedidocompra);
        }
    }

    public function getProveedorById($id)
    {
        return $this->proveedorCtr->getProveedorById($id);
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/pedidocompra/edit.php';
    }

    public function getAllProveedores()
    {
        return $this->proveedorCtr->getAllProveedores();
    }

    public function getAllProductos()
    {
        return $this->productoCtr->getAllProductos();
    }

    public function getProductosPedidoCompraById($id)
    {
        return $this->pedidocompraDAO->getProductosPedidoCompraById($id);
    }

    public function update($id)
    {
        if (isset($_POST["nrocomprobante"])) {
            $pedidocompra = new PedidoCompraMdl($_POST["nrocomprobante"], $_POST["idproveedor"], $_POST["estado"], $_POST["total"], fecha: $_POST["fecha"]);
            $pedidocompra->setIdPedidoCompra($id);
            $this->pedidocompraDAO->update($pedidocompra);
        }
    }

    public function getPedidoCompraById($id)
    {
        return $this->pedidocompraDAO->getPedidoCompraById($id);
    }

    public function getPantallaAnnul()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('annul', 'Anular Pedido Compra', "", BOTONES_POPUP_ANULAR, 'index.php?action=annul'));
        $this->index();
    }

    public function annul($id)
    {
        $pedidocompra = $this->getPedidoCompraById($id);
        $estado = $pedidocompra->getEstado();
        if ($estado != 'anulado' && $estado != 'entregado' && $estado != '')
            $this->pedidocompraDAO->annul($id);
    }

    public function search()
    {
        $this->pedidocompraDAO->search();
    }

    public function getNombreProveedorById($id)
    {
        $proveedor = $this->proveedorCtr->getProveedorById($id);
        return $proveedor['nombre'];
    }

    public function getProductosPedidoById($id)
    {
        return $this->pedidocompraDAO->getProductosPedidoById($id);
    }
}
