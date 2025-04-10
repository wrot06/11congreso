<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generar Certificado - XI Congreso Internacional de Derecho Constitucional</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .title-wrap {
      text-align: center;
      margin-top: 2rem;
    }
  </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" class="static-layout">
  <div class="container">
    <!-- Header -->
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
    
    <!-- Contenido principal -->
    <main>
      <!-- Logo centrado -->
      <div class="text-center my-4">
        <img src="img/logo.png" class="img-fluid" alt="Logo" style="width: 35%;">
      </div>
      
      <!-- Título y formulario -->
      <div class="title-wrap">
        <h3>XI Congreso Internacional de Derecho Constitucional</h3>
        <p>Para generar tu certificado digital, escribe tu número de Identificación y haz clic en Generar Certificado.</p>
        <p>Certificado de prueba (CEDULA 123456789) "Pepito Perez"</p>
        
        <form method="GET" action="consulta.php">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
            <div class="mb-3">
                <input autofocus type="number" class="form-control" id="nombre" name="id" placeholder="Cédula" onkeydown="filtro()" min="100000" max="99999999999" required style="max-width: 400px; margin: 0 auto;">
            </div>
            </div>
            <div class="col-12 text-center">
            <button class="btn btn-success btn-lg" type="submit" name="submit" disabled>Generar Certificado</button>
            </div>
        </div>
        </div>

        </form>
      </div>
    </main>
  </div>
  
  <!-- Bootstrap 5 JS Bundle (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
