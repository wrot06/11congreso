<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asistencia Registro</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .mi-tabla {
      border: 1px solid #ddd;
      border-collapse: collapse;
      margin: 20px;
    }
    .mi-tabla th, .mi-tabla td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    .mi-tabla th {
      background-color: #f2f2f2;
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
        <a href="index.php" class="btn btn-primary">Inicio</a>
      </div>
    </header>
  <?php
    session_start();
    if ($_SESSION["idencargado"] == 0) {
      header("refresh:0;index.php");
    }
  ?>
  
  <div class="container my-4">
    <!-- Imagen centrada -->
    <div class="text-center mb-4">
      <img src="img/pantalla-asistencia.jpg" alt="Ingreso" class="img-fluid" style="width: 35%;">
    </div>
    
    <!-- Título y formulario -->
    <div class="title-wrap">
      <h5>Ingrese el número de identificación del asistente al evento</h5>
      <p>Digitar número de Identificación sin puntos o comas ("números enteros")</p>
      
      <form method="POST" action="asistencia.php" required>
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="mb-3">
              <input autofocus type="number" class="form-control mx-auto" id="nombre" name="id" 
                     placeholder="Cédula" onkeydown="filtro()" min="1000" max="10000000000" required 
                     style="max-width: 300px;">
            </div>
          </div>
          <div class="col-12 text-center">
            <button class="btn btn-primary btn-shadow" type="submit" name="submit">
              Verificar Asistencia
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>
  
  <!-- Bootstrap 5 JS Bundle (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
