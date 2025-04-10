<?php
// Iniciar la sesión y activar output buffering para evitar problemas con header()
session_start();
ob_start();

// Incluir archivos necesarios

require "rene/conexion.php";

// Verificar que se hayan recibido los datos del formulario
if (isset($_POST['idencargado']) && isset($_POST['encargado'])) {
    $idencargado = intval($_POST['idencargado']);
    $encargado = trim($_POST['encargado']);
    $_SESSION["idencargado"] = $idencargado;
} else {
    // Si faltan datos, redirige a login
    header("Location: login.php");
    exit();
}

// Consultar la base de datos para verificar el usuario
$idencargadoEscaped = $conec->real_escape_string($idencargado);
$encargadoEscaped = $conec->real_escape_string($encargado);

$resultado = $conec->query("SELECT idencargado FROM usuarios WHERE idencargado = $idencargadoEscaped");
$total = $resultado ? $resultado->num_rows : 0;

$resultado2 = $conec->query("SELECT encargado FROM usuarios WHERE encargado = '$encargadoEscaped'");
$total2 = $resultado2 ? $resultado2->num_rows : 0;

// Definir la URL de redirección y mensaje a mostrar según el resultado
if ($total == 0 || $total2 == 0) {
    $mensaje = "El Usuario y Contraseña no aparecen o están incorrectos.";
    $redirectUrl = "login.php";
} else {
    $mensaje = "Usuario: " . htmlspecialchars($encargado) . ".";
    $redirectUrl = "control.php";
}

// Limpiar el buffer para evitar problemas al enviar encabezados
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificación de Usuario</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .title-wrap {
      text-align: center;
      margin-top: 2rem;
    }
  </style>
  <script>
    // Redirecciona después de 4 segundos
    setTimeout(function(){
      window.location.href = "<?php echo $redirectUrl; ?>";
    }, 4000);
  </script>
</head>
<body class="static-layout">
  <div class="container my-4">
    <!-- Imagen centrada -->
    <div class="text-center mb-4">
      <img src="img/pantalla-asistencia.jpg" class="img-fluid" style="max-width: 35%;" alt="Usuario">
    </div>
    <div class="title-wrap">
      <h3 class="text-center text-danger"><?php if($total == 0 || $total2 == 0) { echo $mensaje; } ?></h3>
      <h3 class="text-center text-success"><?php if($total != 0 && $total2 != 0) { echo $mensaje; } ?></h3>
      <h3 class="text-center">Espere...</h3>
    </div>
  </div>

  <!-- External JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
  <script src="vendor/bootstrap/popper.min.js"></script>
  <script src="vendor/bootstrap/bootstrap.min.js"></script>
  <script src="vendor/select2/select2.min.js"></script>
  <script src="vendor/owlcarousel/owl.carousel.min.js"></script>
  <script src="vendor/stellar/jquery.stellar.js"></script>
  <script src="vendor/isotope/isotope.min.js"></script>
  <script src="vendor/lightcase/lightcase.js"></script>
  <script src="vendor/waypoints/waypoint.min.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <!-- Main JS -->
  <script src="js/app.min.js"></script>
  <script src="//localhost:35729/livereload.js"></script>
  <script>
      function filtro() {
          var tecla = event.key;
          if (['.', 'e', '+', '-'].includes(tecla)) {
              event.preventDefault();
          }
      }
  </script>
</body>
</html>
