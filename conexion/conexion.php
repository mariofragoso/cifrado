<?php
try {
    $base = new PDO("mysql:host=127.0.0.1;dbname=cifrado", "root", "Wbtbwb1217*");
    echo "Conexion OK";

} catch (Exception $e) {
    die("Error:" . $e->getMessage());

} finally {
    $base = null;
}

?>