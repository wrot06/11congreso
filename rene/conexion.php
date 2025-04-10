<?php
$username = "admin";
$password = "5qnBKRL8?MdYPF3p";
$database = "11congreso2025udenar";
$host = "xi-congreso2025.ce5ko6qo28s7.us-east-1.rds.amazonaws.com";

$conec = new mysqli($host, $username, $password, $database);

if ($conec->connect_error) {
    die("Error de conexión: " . $conec->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8 para soportar caracteres latinos
if (!$conec->set_charset("utf8")) {
    die("Error al establecer el conjunto de caracteres UTF-8: " . $conec->error);
}

//echo "Conexión exitosa a la base de datos con soporte para caracteres latinos!";
?>
