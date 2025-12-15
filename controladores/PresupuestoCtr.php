<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/ReparacionMdl.php';
require_once 'models/PresupuestoDAO.php';
require_once 'models/ProductoPresupuestoMdl.php';
require_once 'controladores/ClienteCtr.php';
require_once 'controladores/ProductoCtr.php';
require_once 'controladores/ToastCtr.php';

class PresupuestoCtr
{
    private $presupuestoDAO;
    private $clienteCtr;
    private $productoCtr;

    private static $instance = null;

    public function __construct()
    {
        $this->presupuestoDAO = new PresupuestoDAO();
        $this->clienteCtr = ClienteCtr::getInstance();
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
            case 'created':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->create();
                    }
                } else {
                    if ($status == "success") {
                        $toast->mostrarToast("exito", "Presupuesto creado");
                    }
                }
                break;
            case 'annulled':
                if ($status != "success") {
                    $this->annulled($id);
                } else {
                    $toast->mostrarToast("exito", "Presupuesto anulado");
                }
                break;
            case 'edited':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ($status != "success") {
                        $this->update($id);
                    }
                } else if ($status == "success") {
                    $toast->mostrarToast("exito", "Presupuesto modificado");
                }
                break;
            case 'facturar':
                if ($status != "success") {
                    $this->facturar($id);
                } else {
                    $toast->mostrarToast("exito", "Presupuesto facturado");
                }
                break;
            case 'cambiarestado':
                if ($status != "success") {
                    $this->cambiarEstado($id);
                } else {
                    $toast->mostrarToast("exito", "Se cambio el estado del presupuesto");
                }
            case 'searched':
                $this->search();
                break;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PresupuestoCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        $presupuestos = $action == "searched" ? $this->search() : $this->presupuestoDAO->getAllPresupuestos();
        if (is_string($presupuestos)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer todos los presupuestos", $presupuestos);
        }

        $presupuestoCtr = $this->getInstance();
        $productosPre = [];
        if ($action == 'see') {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $presupuesto = $this->getPresupuestoById($id);
            if (strtoupper($presupuesto->getTipo()) == "REPARACION") {
                $reparacion = $presupuestoCtr->getReparacionPresupuestoById($id);
            }
            $cliente = $this->getClienteById($presupuesto->getIdCliente());
            $nombreCliente = $cliente['nombre'] . ' ' . $cliente['apellido'];
            $productosPre = $this->getProductosPresupuestoById($presupuesto->getIdPresupuesto());
            $total = 0;
        }

        for ($i = 0; $i < count($presupuestos); $i++) {
            $presupuestos[$i][1] = $this->getNombreClienteById($presupuestos[$i][1]);
        }

        session_start();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRESUPUESTOS, $presupuestos, [3, 4, 6, 0, 2]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        // Cargar la vista con los datos
        require_once 'vistas/presupuesto/presupuesto.php';
    }

    public function getReparacionPresupuestoById($id)
    {
        $reparacion = $this->presupuestoDAO->getReparacionPresupuestoById($id);

        if (is_string($reparacion)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer la reparacion", $reparacion);
        }
        return $reparacion;
    }

    public function getPantallaCreate()
    {
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $this->index();
        require_once 'vistas/presupuesto/create.php';
    }

    public function create()
    {
        if (isset($_POST['tipo'])) {
            if ($_POST['tipo'] == "Venta") {
                // Validar que existan productos para presupuestos de venta
                if (!isset($_POST['idproductos']) || empty($_POST['idproductos'])) {
                    UtilidadesDAO::getInstance()->showStatus("presupuestos", "Debe agregar al menos un producto al presupuesto de venta", "created");
                    return;
                }
                $productos_total = $this->getProductos_Total();
                $estado = isset($_POST['tipo']) ? $_POST['tipo'] == 'Venta' ? 'Presupuestado' : 'Pendiente presupuesto' : '';
                $presupuesto = new PresupuestoMdl(
                    $_POST['idcliente'],
                    $productos_total->productos,
                    $this->getNuevoNroComprobante(),
                    $_POST['tipo'],
                    $estado,
                    '0001',
                    $productos_total->total
                );
                $status = $this->presupuestoDAO->create($presupuesto);
                $erroresStock = [];

                foreach ($productos_total->productos as $productoVenta) {
                    $id = $productoVenta->getIdProducto();
                    $cantidad = $productoVenta->getCantidad();
                    $resultado = $this->productoCtr->actualizarStockProducto($id, $cantidad, 'restar');

                    if ($resultado !== "") {
                        $erroresStock[] = "Error al actualizar stock del producto con ID $id: $resultado";
                    }
                }
            } else if ($_POST['tipo'] == "Reparacion") {
                $presupuesto = new PresupuestoMdl($_POST['idcliente'], [], $this->getNuevoNroComprobante(), $_POST['tipo'], 'pendiente presupuesto', '0001', 0);
                $reparacion = new ReparacionMdl($_POST['modelo'], $_POST['marca'], $_POST['nroserie'], $_POST['descripcion']);
                $status = $this->presupuestoDAO->create($presupuesto, $reparacion);
            }
            if (!empty($erroresStock)) {
                // Mostrar los errores acumulados
                $erroresTexto = implode(" | ", $erroresStock);
                UtilidadesDAO::getInstance()->showStatus("presupuestos", $erroresTexto, "created");
            } else {
                UtilidadesDAO::getInstance()->showStatus("presupuestos", $status, "created");
            }
        }
    }

    private function getProductos_Total()
    {
        $productos = [];
        $precioTotal = 0;
        foreach ($_POST['idproductos'] as $index => $idproducto) {
            $precioUnit = $this->productoCtr->getProductoById($idproducto)['precioventa'];
            $cantidad = intval($_POST['cantidad'][$index]);
            $producto = new ProductoPresupuestoMdl($idproducto, $precioUnit, $cantidad);
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
        require_once 'vistas/presupuesto/edit.php';
    }

    public function getNuevoNroComprobante()
    {
        $nroComprobanteDB = $this->presupuestoDAO->getNuevoNroComprobante();
        if (is_string($nroComprobanteDB)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer el numero del comprobante", $nroComprobanteDB);
        }
        $auxNroComprobante = strval($nroComprobanteDB + 1);
        $nroComprobante = str_pad($auxNroComprobante, 10, 0, STR_PAD_LEFT);
        return $nroComprobante;
    }

    public function getNombreClienteById($id)
    {
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente['nombre'] . ' ' . $cliente['apellido'];
    }

    public function getClienteById($id)
    {
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente;
    }

    public function getProductoById($id)
    {
        $producto = $this->productoCtr->getProductoById($id);
        return $producto;
    }

    public function getProductosPresupuestoById($id)
    {
        $productoPresupuesto = $this->presupuestoDAO->getProductosPresupuestoById($id);
        if (is_string($productoPresupuesto)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los productos del presupuesto", $productoPresupuesto);
        }
        return $productoPresupuesto;
    }

    public function update($id)
    {
        if (isset($_POST["idcliente"]) || !empty($id)) {
            $presupuesto = $this->getPresupuestoById($id);
            if ($_GET["module"] == "presupuestos") {
                $presupuesto->setIdCliente($_POST['idcliente']);
            }

            $tipo = $presupuesto->getTipo();
            
            // Validar que presupuestos de venta tengan al menos un producto
            if ($tipo === "Venta" && (!isset($_POST['idproductos']) || empty($_POST['idproductos']))) {
                $status = "Debe agregar al menos un producto al presupuesto de venta";
                if ($_GET["module"] == "presupuestos") {
                    UtilidadesDAO::getInstance()->showStatus("presupuestos", $status, "edited");
                }
                return $status;
            }

            $productosNuevos = [];
            $productosViejos = [];
            $total = 0;

            // Solo procesar productos si es tipo Venta o tipo reparacion con productos
            if (($tipo === "Venta" && isset($_POST['idproductos'])) || ($tipo === "Reparacion" && !empty($_POST['idproductos']))) {
                $productos_total = $this->getProductos_Total();
                $productosNuevos = $productos_total->productos;
                $productosViejos = $presupuesto->getProductos();

                // Crear mapas por ID para búsqueda rápida
                $mapaViejos = [];
                foreach ($productosViejos as $productoViejo) {
                    $mapaViejos[$productoViejo["idproducto"]] = $productoViejo["cantidad"];
                }

                $mapaNuevos = [];
                foreach ($productosNuevos as $productoNuevo) {
                    $mapaNuevos[$productoNuevo->getIdProducto()] = $productoNuevo;
                }

                // Recorrer nuevos productos
                foreach ($productosNuevos as $productoNuevo) {
                    $idProd = $productoNuevo->getIdProducto();
                    $cantidadNueva = $productoNuevo->getCantidad();

                    if (isset($mapaViejos[$idProd])) {
                        $cantidadVieja = $mapaViejos[$idProd];
                        $diferencia = $cantidadNueva - $cantidadVieja;

                        if ($diferencia != 0) {
                            $operacion = $diferencia > 0 ? 'restar' : 'sumar';
                            $this->productoCtr->actualizarStockProducto($idProd, abs($diferencia), $operacion);
                        }
                    } else {
                        // Producto nuevo: restar toda la cantidad
                        $this->productoCtr->actualizarStockProducto($idProd, $cantidadNueva, 'restar');
                    }
                }

                // Detectar productos eliminados
                foreach ($productosViejos as $productoViejo) {
                    $idViejo = $productoViejo["idproducto"];
                    if (!isset($mapaNuevos[$idViejo])) {
                        // Producto eliminado: se devuelve al stock
                        $this->productoCtr->actualizarStockProducto($idViejo, $productoViejo["cantidad"], 'sumar');
                    }
                }
                
                $total = $tipo === "Reparacion"?  isset($_POST['manodeobra']) ?  floatval($productos_total->total) + floatval($_POST['manodeobra']) : $productos_total->total : $productos_total->total;
            } else if ($tipo === "Reparacion") {
                // Para reparación sin productos
                // Si viene de reparaciones (evaluar), actualizar con manodeobra
                // Si viene de presupuestos (editar), preservar total según estado
                $modulo = isset($_GET['module']) ? $_GET['module'] : '';
                
                if ($modulo === 'reparaciones') {
                    // Viene de reparaciones/evaluate.php - usar manodeobra para actualizar
                    $total = isset($_POST['manodeobra']) ? floatval($_POST['manodeobra']) : $presupuesto->getTotal();
                } else {
                    // Viene de presupuestos/edit.php - preservar según estado
                    $estado = $presupuesto->getEstado();
                    if ($estado === "Pendiente presupuesto") {
                        $total = 0;
                    } else {
                        $total = $presupuesto->getTotal();
                    }
                }
            }

            // Actualizar el presupuesto con los nuevos productos/total
            $presupuesto->setProductos($productosNuevos);
            $presupuesto->setTotal($total);

            $status = $this->presupuestoDAO->updatePresupuesto($presupuesto);
        }
        if ($_GET["module"] == "presupuestos") {
            UtilidadesDAO::getInstance()->showStatus("presupuestos", $status, "edited");
        }
        
        return $status;
    }


    public function getPresupuestoById($id)
    {
        $toast = new ToastCtr();
        $presupuestoBD = $this->presupuestoDAO->getPresupuestoById($id);
        if (is_string($presupuestoBD)) {
            $toast->mostrarToast("error", "error al traer el presupuesto", $presupuestoBD);
            exit;
        }
        $productosPresupuestoBD = $this->getProductosPresupuestoById($id);

        if (is_string($productosPresupuestoBD)) {
            $toast->mostrarToast("error", "error al buscar presupuesto: " . $presupuestoBD);
            exit;
        }
        $presupuesto = new PresupuestoMdl($presupuestoBD['idcliente'], $productosPresupuestoBD, $presupuestoBD['nrocomprobante'], $presupuestoBD['tipo'], $presupuestoBD['estado'], $presupuestoBD['puntoventa'], $presupuestoBD['total']);
        $presupuesto->setIdPresupuesto($id);
        $presupuesto->setFecha($presupuestoBD['fecha']);
        return $presupuesto;
    }

    public function getPantallaAnnul()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('annul', 'Anular Presupuesto', "", BOTONES_POPUP_ANULAR, 'index.php?action=annul'));
        $this->index();
    }

    public function annulled($id)
    {
        $presupuesto = $this->getPresupuestoById($id);
        $estado = $presupuesto->getEstado();

        if ($estado != 'Pendiente presupuesto' && $estado != 'En reparacion' && $estado != '') {
            $status = $this->presupuestoDAO->annul($id);

            // Obtener productos del presupuesto ya guardado en BD
            $productosPresupuestados = $this->presupuestoDAO->getProductosPresupuestoById($id);

            foreach ($productosPresupuestados as $productoVenta) {
                $id = $productoVenta['idproducto'];  // o el nombre correcto en tu tabla
                $cantidad = $productoVenta['cantidad'];
                $this->productoCtr->actualizarStockProducto($id, $cantidad, 'sumar');
            }

            UtilidadesDAO::getInstance()->showStatus("presupuestos", $status, "annulled");
        }
    }


    public function getAllClientes()
    {
        return $this->clienteCtr->getAllClientes();
    }

    public function getAllProductos()
    {
        return $this->productoCtr->getAllProductos();
    }

    public function facturar($id)
    {
        $presupuesto = $this->getPresupuestoById($id);
        $estado = $presupuesto->getEstado();
        if ($estado != 'Pendiente presupuesto' && $estado != 'En reparacion' && $estado != '' && $estado != 'Facturado') {
            $presupuesto->setEstado('Facturado');
            $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
            $status = $this->updatePresupuesto($presupuesto);
            UtilidadesDAO::getInstance()->showStatus("presupuestos", $status, "facturar");
        }
    }

    private function updatePresupuesto($presupuesto)
    {
        return $this->presupuestoDAO->updatePresupuesto($presupuesto);
    }

    public function cambiarEstado($id)
    {
        $presupuesto = $this->getPresupuestoById($id);
        $tipo = $presupuesto->getTipo();
        $estado = $presupuesto->getEstado();
        $status = "";
        if ($tipo == "Venta") {
            if ($estado == "Presupuestado") {
                $presupuesto->setEstado('Facturado');
                $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
                $status = $this->updatePresupuesto($presupuesto);
            }
        } else {
           
            if ($estado == "Presupuestado") {
                $presupuesto->setEstado('Pendiente reparacion');
                $status = $this->updatePresupuesto($presupuesto);
            }
            if ($estado == "Reparado") {
                $presupuesto->setEstado('Facturado');
                $presupuesto->setNroComprobante('C-' . $presupuesto->getNroComprobante() . '-0001');
                $status = $this->updatePresupuesto($presupuesto);
            }
        }
        UtilidadesDAO::getInstance()->showStatus("presupuestos", $status, "cambiarestado");
    }

    public function search()
    {
        $result = $this->presupuestoDAO->search();
        if (is_string($result)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al buscar presupuestos", $result);
        }
        return $result;
    }

    public function getPresupuestoDAO()
    {
        return $this->presupuestoDAO;
    }
}
