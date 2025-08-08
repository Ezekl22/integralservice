<?php

function loadEnv($path = __DIR__ . '\.env') {
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) continue;

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Quitar comillas si las tiene
        $value = trim($value, "\"'");

        // Setear en el entorno
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

?>