<?php
session_start();
$_SESSION["idencargado"] = "X";

date_default_timezone_set('America/Bogota');
$fechaActual = date("Y-m-d h:i:s A");
$fechaEntera = strtotime($fechaActual);
$dia = date("d", $fechaEntera);
$mes = date("m", $fechaEntera);
$ano = date("Y", $fechaEntera);
$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
$mesLargo = $meses[(int)$mes - 1];

require "rene/conexion.php";

$id = $_POST['id'] ?? $_GET['id'] ?? null;
$datos = [];
$roles = [];
if ($id) {
    $_SESSION["idencargado"] = "B";
    $sql = "SELECT p.id, t.nombre AS tipo, p.nombres, p.correo, p.genero, p.carnet, p.doctipo 
            FROM participantes p 
            JOIN participante_tipo pt ON p.id = pt.participante_id 
            JOIN tipo t ON pt.tipo_id = t.id 
            WHERE p.id = ?";
    $stmt = $conec->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($fila = $result->fetch_assoc()) {
        $datos = $fila;
        $roles[] = $fila['tipo'];
    }
    $roles = array_unique($roles);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificación - XI Congreso Internacional de Derecho Constitucional</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .certificate-container { max-width: 600px; margin: 2rem auto; padding: 1.5rem; border: 1px solid #ddd; border-radius: 8px; background-color: #f8f9fa; }
    .certificate-title, .certificate-footer { text-align: center; }
    .certificate-text { text-align: justify; }
  </style>
</head>
<body>
<div class="container my-4">
  <div class="text-center mb-4">
    <img src="img/logo.png" class="img-fluid" alt="Logo" style="max-width: 300px;">
  </div>
  <div class="certificate-container">
  <?php if (!empty($datos)): ?>
    <h4 class="certificate-title mb-4"><b>CERTIFICACIÓN</b></h4>
    <?php
      $doctipo = $datos['doctipo'];
      $larguito = ($doctipo == 'CC') ? "Cédula de Ciudadanía número " :
                  (($doctipo == 'TI') ? "Tarjeta de Identidad número " : "documento número " . htmlspecialchars($datos['correo']));
      $roles_text = strtoupper(implode(" y ", $roles));
    ?>
    <p class="certificate-text">
      El Centro de Investigaciones y Estudios Socio-Jurídicos (CIESJU) de la Universidad de Nariño hace constar que 
      <b><?= htmlspecialchars($datos['nombres']) ?></b>, identificado(a) con <?= $larguito . htmlspecialchars($datos['id']) ?>, 
      asistió al XI Congreso Internacional de Derecho Constitucional en calidad de <?= $roles_text ?>, 
      realizado los días 23, 24 y 25 de abril de 2025, con una intensidad de 36 horas académicas, 
      el cual se desarrolló en las instalaciones del Club Colombia de la ciudad de Pasto, Departamento de Nariño, República de Colombia.
    </p>
    <p class="certificate-text">
      En constancia de lo anterior, se firma en San Juan de Pasto, <?= $dia ?> de <?= $mesLargo ?> de <?= $ano ?>.
    </p>
    <?php if ($datos['id'] != "98398521"): ?>
      <p class="certificate-text">
        <b>LEONARDO A. ENRÍQUEZ MARTÍNEZ</b><br>
        Decano<br>
        Facultad de Derecho y Ciencias Políticas<br>
        Universidad de Nariño
      </p>
    <?php endif; ?>
    <?php if ($datos['id'] != "13069293"): ?>
      <p class="certificate-text">
        <b>CRISTHIAN ALEXANDER PEREIRA OTERO</b><br>
        Director<br>
        Centro de Investigación y Estudios Socio-Jurídicos<br>
        Universidad de Nariño
      </p>
    <?php endif; ?>
    <?php foreach ($roles as $role): ?>
      <form method="POST" action="qr/qrcreador.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <input type="hidden" name="rol" value="<?= htmlspecialchars($role) ?>">
        <div class="text-center my-3">
          <button class="btn btn-primary btn-lg" type="submit" name="submit">
            DESCARGAR CERTIFICADO <?= strtoupper(htmlspecialchars($role)) ?>
          </button>
        </div>
      </form>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center">Este número de identificación no aparece en nuestra base de datos</p>
    <?php header("refresh:8;certificar.php"); exit; ?>
  <?php endif; ?>
  </div>
</div>
<script>
  if (performance.navigation.type == 1 && window.location.href.indexOf('#') == -1) {
    window.location.href = 'certificar.php';
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
