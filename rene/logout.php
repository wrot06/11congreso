<?php
session_start();       // Inicia la sesión
$_SESSION = [];        // Vacía el arreglo de la sesión
session_destroy();     // Destruye la sesión

// Redirige al usuario a la página de login o a la página principal
header("Location: ../index.php");
exit;
?>
