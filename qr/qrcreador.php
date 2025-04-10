<?php
// Activar visualización de errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../qr/phpqrcode/qrlib.php';
require '../rene/conexion.php';

// Directorio para almacenar la imagen QR
$dir = 'temp/';
if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        error_log("Error: No se pudo crear el directorio $dir.");
        die("Error: No se pudo crear el directorio $dir.");
    }
}
if (!is_writable($dir)) {
    error_log("Error: El directorio $dir no es escribible.");
    die("Error: El directorio $dir no es escribible. Revisa los permisos.");
}

$filename = $dir . 'temp.png';
$tamano = 10;
$level = 'M';
$frameSize = 3;

// Verificar ID enviado
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
} else {
    die("Error: No se proporcionó el ID.");
}

// Verificar rol enviado y guardarlo en sesión
if (isset($_POST['rol']) && !empty($_POST['rol'])) {
    $_SESSION['rol'] = $_POST['rol'];
} else {
    die("Error: No se proporcionó el rol.");
}

// Insertar en la tabla "descargas"
$idEscaped = mysqli_real_escape_string($conec, $id);
$consulta = "INSERT INTO descargas(id, numero) VALUES('$idEscaped', NULL)";
if (!mysqli_query($conec, $consulta)) {
    error_log("Error al insertar en descargas: " . mysqli_error($conec));
    die("Error al insertar en descargas.");
}

// Consulta para obtener el participante y generar la URL del QR
$sql = "SELECT id FROM participantes WHERE id = " . intval($id);
$result = $conec->query($sql);
if ($result && $result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $datosQR = "http://ciesju-app.es/consulta.php?id=" . $fila['id'] . "&submit=";
    $_SESSION['id'] = $fila['id'];
    $result->free();
} else {
    error_log("No se encontró el participante con el ID: " . $id);
    die("No se encontró el participante con ese ID.");
}

// Generar el contenido del QR
$contenido = $datosQR;
ob_start();
QRcode::png($contenido, $filename, $level, $tamano, $frameSize);
$output = ob_get_clean();

// Verificar que se generó el archivo QR
if (!file_exists($filename)) {
    error_log("Error: La imagen QR no se generó en $filename. Salida del buffer: $output");
    echo "Error generando la imagen QR. Por favor, revisa los logs para más detalles.";
} else {
    echo "La imagen QR se generó correctamente: $filename";
    echo '<script>
            window.open("../pdf/PDFcertificado.php", "_blank");
            setTimeout(function(){
                window.location.href = "../consulta.php?id='.$id.'&submit=";
            }, 0);
          </script>';
}
?>
