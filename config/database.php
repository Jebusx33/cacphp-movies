<?php
function conectarDB() {
    $db = mysqli_connect('localhost', 'id22411218_cac_peliculas', 'LgM3}_3C)XHcfU', 'id22411218_cacmovies');
    if (!$db) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    return $db;
}
?>
