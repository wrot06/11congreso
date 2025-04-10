<!DOCTYPE html>
<html lang="en">

<?php   require 'rene/head.php';  ?>
<body data-spy="scroll" data-target="#navbar" class="static-layout"><br><br>
<center><img src="img/logo.png" style="width: 35%;"><br><br></center>



<div class="title-wrap">
<p>Digitar los siguientes datos sin puntos o comas "números enteros"</p>







<form method="POST" action="asistencia.php"  required>
<div class="row">

<div class="col-md-12 form-group">
<center><input style="width: 300px;" type="number" class="form-control" id="nombre" name="id" placeholder="Usuario" required></center></div>

<div class="col-md-12 form-group">
<center><input style="width: 300px;" type="number" class="form-control" id="nombre" name="id" placeholder="Contraseña" onkeydown="filtro()" min="10000" max="10000000000" size="10" required></center></div>

<div class="col-md-12 text-center">
<button class="btn btn-primary btn-shadow btn" type="submit" name="submit">Ingresar</button>                                
</div>

</div>
</form>

  </div>


















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
