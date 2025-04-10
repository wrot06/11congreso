<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificación Asistencia</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .mi-tabla {
      margin: 20px auto;
      max-width: 600px;
    }
    .title-wrap {
      text-align: center;
      margin-top: 2rem;
    }
  </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" class="static-layout">
<div class="container">
<header class="d-flex justify-content-between align-items-center p-3">
      <!-- Logo en la izquierda -->
      <div class="header-left">
        <img src="img/letras11CONGRESO.png" class="img-fluid" alt="Logo Congreso" style="max-height: 100px;">
      </div>
      <!-- Botón de inicio en la derecha -->
      <div class="header-right">
        <a href="control.php" class="btn btn-primary">Atras</a>
      </div>
    </header>
<?php
session_start();
if ($_SESSION["idencargado"] == 0) {
    header("Location: index.php");
    exit();
}

// Configurar zona horaria y obtener fecha actual
date_default_timezone_set('America/Bogota');
$fechaActual = date("Y-m-d H:i:s"); 
$today = date("Y-m-d");
$currentTime = date("H:i");
$entrega = '0';

// Obtener el ID del participante desde POST o GET
$id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : null);
if ($id === null) {
    die("<p class='text-center'>No se ha proporcionado un número de identificación.</p>");
}

require "rene/conexion.php";

// Preparar consulta para obtener los datos del participante (único registro esperado)
$query = "SELECT id, nombres, correo, tipo2 FROM participantes WHERE id = ?";
$stmt = $conec->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "<p class='text-center'>Este número de identificación no aparece en nuestra base de datos</p>";
    echo "<h1 class='text-center'>Solicitar Recibo de pago</h1>";
    header("refresh:5;url=control.php");
    exit();
}
$fila = $result->fetch_assoc();
$stmt->close();
?>
<div class="container my-4">
  <!-- Imagen superior centrada -->
  <div class="text-center mb-4">
    <img src="img/pantalla-asistencia.jpg" alt="Ingreso" class="img-fluid" style="max-width: 25%;">
  </div>
  
  <!-- Card que muestra la información del participante -->
  <div class="card mx-auto" style="max-width: 600px;">
    <div class="card-header text-center">
      <h4><?php echo $fila['nombres']; ?></h4>
      <p>Identificación: <?php echo htmlspecialchars($fila['id']); ?> | Tipo: <?php echo htmlspecialchars($fila['tipo2']); ?></p>
    </div>
    <div class="card-body text-center">
      <!-- Formulario para confirmar ingreso -->
      <form method="POST" action="ingresafecha.php" class="mb-3">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="hidden" name="fecha" value="<?php echo $fechaActual; ?>">
        <button class="btn btn-primary" type="submit" name="submit">Confirmar Ingreso</button>
      </form>
      <?php 
      // Verificar si ya se realizó la entrega de libros
      $queryEntrega = "SELECT entrega FROM entregas WHERE id = ?";
      $stmtEntrega = $conec->prepare($queryEntrega);
      $stmtEntrega->bind_param("i", $id);
      $stmtEntrega->execute();
      $resultEntrega = $stmtEntrega->get_result();
      $row_cnt = $resultEntrega->num_rows;
      $stmtEntrega->close();
      
      if ($row_cnt == 1) {
          echo "<p class='text-success'>La entrega de LIBROS ya se realizó.</p>";
      } else {
      ?>
      <!-- Formulario para confirmar entrega, agenda e ingreso -->
      <form method="POST" action="ingresafecha.php" class="mb-3">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="hidden" name="entrega" value="1">
        <input type="hidden" name="fecha" value="<?php echo $fechaActual; ?>">
        <button class="btn btn-secondary" type="submit" name="submit2">Confirmar entrega, agenda e ingreso</button>
      </form>
      <?php } ?>
    </div>
  </div>
  
  <!-- Historial de asistencias -->
  <div class="title-wrap">
    <h5>Historial de Asistencias</h5>
  </div>
  <div class="table-responsive mx-auto mi-tabla">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Hora / Fecha</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $contador = 0;
        $queryAsistencia = "SELECT fecha FROM asistencia WHERE id = ? ORDER BY registro DESC";
        $stmtAsistencia = $conec->prepare($queryAsistencia);
        $stmtAsistencia->bind_param("i", $id);
        $stmtAsistencia->execute();
        $resultAsistencia = $stmtAsistencia->get_result();
        while ($fila2 = $resultAsistencia->fetch_assoc()) {
            $contador++;
            $hora  = date('H:i', strtotime($fila2['fecha']));
            $fecha = date('d-m', strtotime($fila2['fecha']));
            echo "<tr>";
            echo "<td>$contador</td>";
            echo "<td><strong>Hora:</strong> $hora | <strong>Fecha:</strong> $fecha</td>";
            echo "</tr>";
        }
        $stmtAsistencia->close();
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
