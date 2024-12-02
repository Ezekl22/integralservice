<?php
class ErrorCtr
{
    private static $instance = null;
    public function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ErrorCtr();
        }
        return self::$instance;
    }

    public function showError(string $error, string $texto)
    {
        if (is_string($error)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", $texto . ": " . $error);
        }

    }
}
