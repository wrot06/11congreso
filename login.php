<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso - Ingreso</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .title-wrap {
      text-align: center;
      margin-top: 2rem;
    }
    .login-img {
      max-width: 35%;
    }
    .login-form {
      max-width: 300px;
      margin: 0 auto;
    }
  </style>
</head>
<body class="static-layout" data-bs-spy="scroll" data-bs-target="#navbar">
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

  <?php session_start(); ?>
    <div class="container my-4">
      <div class="text-center mb-4">
      <!-- Imagen de usuario centrada -->
      <div class="text-center mb-4">
        <img src="img/pantalla-asistencia.jpg" alt="Usuario" class="img-fluid login-img">
      </div>
      
      <!-- Título y formulario -->

        <p>Digitar los siguientes datos</p>
        <form method="POST" action="verificar.php" required>
          <div class="row justify-content-center">
            <div class="col-12 mb-3">
              <input autofocus type="text" class="form-control login-form" id="encargado" name="encargado" placeholder="Usuario" required>
            </div>
            <div class="col-12 mb-3">
              <input type="number" class="form-control login-form" id="idencargado" name="idencargado" placeholder="Contraseña" onkeydown="filtro()" min="1000" max="10000000000" required>
            </div>
            <div class="col-12 text-center">
              <button class="btn btn-primary btn-shadow" type="submit" name="submit">Entrar</button>
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

















	<!-- External JS -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
	<script src="vendor/bootstrap/popper.min.js"></script>
	<script src="vendor/bootstrap/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js "></script>
	<script src="vendor/owlcarousel/owl.carousel.min.js"></script>
	<script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
	<script src="vendor/isotope/isotope.min.js"></script>
	<script src="vendor/lightcase/lightcase.js"></script>
	<script src="vendor/waypoints/waypoint.min.js"></script>
	 <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
	 
	<!-- Main JS -->
	<script src="js/app.min.js "></script>
	<script src="//localhost:35729/livereload.js"></script>
    <script>
        function filtro()
        {
        var tecla = event.key;
        if (['.','e','+','-'].includes(tecla))
           event.preventDefault()


        }


    </script>
</body>
</html>
