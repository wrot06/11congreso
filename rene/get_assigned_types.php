<?php
// get_assigned_types.php
// Asegúrate de que la ruta sea correcta (si está en la misma carpeta, funciona igual)
require "conexion.php"; // Se espera que $conec esté definido

$participante_id = isset($_GET['participante_id']) ? intval($_GET['participante_id']) : 0;
$assignedTypes = [];

if ($participante_id > 0) {
    $sql = "SELECT t.id, t.nombre 
            FROM participante_tipo pt 
            JOIN tipo t ON pt.tipo_id = t.id 
            WHERE pt.participante_id = ?";
    $stmt = $conec->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $participante_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $assignedTypes[] = $row;
        }
        $stmt->close();
    }
}

$conec->close();
header('Content-Type: application/json');
echo json_encode($assignedTypes);
?>
