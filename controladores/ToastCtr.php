<?php
class ToastCtr
{

    public function __construct()
    {

    }

    public function mostrarToast(string $tipo, string $texto, string $descripcionError = "")
    {
        if ($tipo != "") {
            echo '<script>mostrarToast("' . $tipo . '","' . $texto . '","' . $descripcionError . '") </script>';
        }
    }
}