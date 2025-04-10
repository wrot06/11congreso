<?php
session_start();
session_regenerate_id(true); // Mejora la seguridad de la sesión
$_SESSION["idencargado"] = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>APP-CIESJU</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <style>
    /* Estilo para las casillas del menú */
    .menu-box {
      width: 150px;
      height: 150px;
      margin: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #ddd;
      border-radius: 8px;
      background-color: #f8f9fa;
      text-decoration: none;
      transition: background-color 0.3s, border-color 0.3s;
    }
    .menu-box:hover {
      background-color: #e9ecef;
      border-color: #adb5bd;
    }
    .menu-text {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
    }
    /* Contenedor para el menú, con menos espacio superior */
    .menu-container {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <!-- Encabezado con logo -->
  <header class="text-center py-2">
    <img src="img/letras11CONGRESO.png" alt="Logo" class="img-fluid" style="max-width: 400px;">
  </header>

  <!-- Menú en casillas centrado -->
  <div class="container menu-container">
    <div class="row justify-content-center">
      <div class="col-auto">
        <a href="listado.php" class="menu-box">
          <span class="menu-text">Listados</span>
        </a>
      </div>
      <div class="col-auto">
        <a href="certificar.php" class="menu-box">
          <span class="menu-text">Certificados</span>
        </a>
      </div>
      <div class="col-auto">
        <a href="login.php" class="menu-box">
          <span class="menu-text">Asistencia</span>
        </a>
      </div>
      <div class="col-auto">
        <a href="relacion.php" class="menu-box">
          <span class="menu-text">Roles</span>
        </a>
      </div>   
      <div class="col-auto">
        <a href="carnet.php" class="menu-box">
          <span class="menu-text">Carnets</span>
        </a>
      </div>       
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
