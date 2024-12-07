<?php
class ToastCtr
{

    public function __construct()
    {

    }

    public function mostrarToast(string $tipo, string $texto, string $descripcionError = "")
    {
        if ($tipo != "") {
            $mensaje = $texto == "" ? $this->getTextoError() : $texto;
            echo '<script>mostrarToast("' . $tipo . '","' . $mensaje . '","' . $descripcionError . '") </script>';
        }
    }

    private function getTextoError()
    {
        $modulo = isset($_GET['module']) ? $_GET['module'] : "";
        $accion = isset($_GET['action']) ? $_GET['action'] : "";
        $texto = "";

        if ($accion != "" && $modulo != "") {
            $letrasEliminadas = $modulo == "reparaciones" ? "es" : "s";
            $articulo = $modulo == "reparaciones" ? "la " : "el ";
            $moduloSingular = $articulo . rtrim($modulo, $letrasEliminadas);
            switch ($accion) {
                case 'created':
                    $texto = "Error al crear $moduloSingular";
                    break;
                case 'edited':
                    $texto = "Error al editar $moduloSingular";
                    break;
                case 'deleted':
                    $texto = "Error al eliminar $moduloSingular";
                    break;
                default:
                    $texto = "Error";
                    break;
            }
        }
        return $texto;
    }
}