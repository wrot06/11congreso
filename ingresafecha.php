<?php
session_start();
require 'asistencia.php';
require "rene/conexion.php";

// Mostrar errores para depuración (desactiva en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar y sanitizar el ID recibido desde POST
if (!isset($_POST['id']) || empty($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Error: Se requiere un ID numérico.");
}
$id = intval($_POST['id']);

// Definir la fecha actual en formato 24 horas (compatible con MySQL)
$fechaActual = date("Y-m-d H:i:s");

// Para el caso de la segunda acción, se espera que la variable 'entrega' se reciba también
$entrega = isset($_POST['entrega']) ? $_POST['entrega'] : null;

// Asegurarse de que el idencargado esté definido en la sesión y sea un entero
$idEncargado = isset($_SESSION['idencargado']) ? intval($_SESSION['idencargado']) : 0;
if ($idEncargado === 0) {
    die("Error: idencargado no está definido en la sesión.");
}

function redirigirConAlerta($mensaje, $url) {
    echo '<script>alert("' . addslashes($mensaje) . '");</script>';
    echo '<script>window.location.replace("' . $url . '");</script>';
    exit();
}

if (isset($_POST['submit'])) {
    $stmt = $conec->prepare("INSERT INTO asistencia(id, fecha, idencargado) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error preparando la consulta: " . $conec->error);
    }
    $stmt->bind_param("isi", $id, $fechaActual, $idEncargado);
    if ($stmt->execute()) {
        header("Location: control.php");
        exit();
    } else {
        echo '<script>alert("Error en los datos: ' . $stmt->error . '");</script>';
    }
    $stmt->close();
}

if (isset($_POST['submit2'])) {
    if ($entrega === null) {
        die("Error: La variable 'entrega' no está definida.");
    }
    
    $conec->begin_transaction();    
    $stmt1 = $conec->prepare("INSERT INTO entregas(id, entrega, idencargado, fecha_ingreso) VALUES (?, ?, ?, NOW())");
    if (!$stmt1) {
        $conec->rollback();
        die("Error preparando la consulta para entregas: " . $conec->error);
    }
    $stmt1->bind_param("iii", $id, $entrega, $idEncargado);
    $resultado1 = $stmt1->execute();
    $stmt1->close();
    
    $stmt2 = $conec->prepare("INSERT INTO asistencia(id, fecha, idencargado) VALUES (?, ?, ?)");
    if (!$stmt2) {
        $conec->rollback();
        die("Error preparando la consulta para asistencia: " . $conec->error);
    }
    $stmt2->bind_param("isi", $id, $fechaActual, $idEncargado);
    $resultado2 = $stmt2->execute();
    $stmt2->close();
    
    if ($resultado1 && $resultado2) {
        $conec->commit();
        header("Location: control.php");
        exit();
    } else {
        $conec->rollback();
        echo '<script>alert("Error en los datos: ' . $conec->error . '");</script>';
    }
    
}
?>
