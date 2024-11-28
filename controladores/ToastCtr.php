<?php
class ToastCtr
{

    public function __construct()
    {

    }

    public function mostrarToast(string $tipo, string $texto)
    {
        if ($tipo != "") {
            echo "<script>mostrarToast('$tipo','$texto') </script>";
        }
    }
}