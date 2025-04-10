<?php
// Cargar archivos de configuración y conexión
require 'rene/conexion.php';

// Consulta para obtener todos los registros para la tabla, incluyendo los tipos asignados
$sql = "SELECT p.*, GROUP_CONCAT(t.nombre SEPARATOR ', ') AS tipo2
FROM participantes p
LEFT JOIN participante_tipo pt ON p.id = pt.participante_id
LEFT JOIN tipo t ON pt.tipo_id = t.id
GROUP BY p.id
ORDER BY p.carnet ASC";
$resultado = mysqli_query($conec, $sql);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conec));
}
$contador = 0;

// Consulta para obtener los tipos únicos para el dropdown (se extrae desde la tabla "tipo")
$queryTipos = "SELECT nombre FROM tipo ORDER BY nombre ASC";
$resultTipos = mysqli_query($conec, $queryTipos);
$tipos = [];
if ($resultTipos) {
    while ($row = mysqli_fetch_assoc($resultTipos)) {
        $tipos[] = $row["nombre"];
    }
} else {
    die("Error en la consulta de tipos: " . mysqli_error($conec));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de Participantes</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery UI CSS (opcional) -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
    .title-wrap {
      text-align: center;
      margin: 30px 0;
    }
  </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" class="static-layout">
  <div class="container">
    <!-- Header: Imagen, buscador, dropdown y botón de inicio -->
    <header class="d-flex justify-content-between align-items-center p-3">
      <!-- Sección izquierda: logo -->
      <div class="header-left">
        <img src="img/letras11CONGRESO.png" class="img-fluid" alt="Logo Congreso" style="max-height: 100px;">
      </div>
      <!-- Sección derecha: buscador, dropdown y botón -->
      <div class="header-right d-flex align-items-center" style="gap: 5px;">
        <div style="width: 250px;">
          <input type="text" id="buscador" class="form-control" placeholder="Buscar en la lista...">
        </div>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownTipo" data-bs-toggle="dropdown" aria-expanded="false">
            Seleccionar Tipo
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownTipo">
            <a class="dropdown-item" href="#" data-tipo="all">Todos</a>
            <?php foreach($tipos as $tipo): ?>
              <a class="dropdown-item" href="#" data-tipo="<?= htmlspecialchars($tipo) ?>"><?= htmlspecialchars($tipo) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
        <a href="index.php" class="btn btn-primary">Inicio</a>
      </div>
    </header>

    <!-- Título -->
    <div class="text-center mb-3">
      <p>Listado General</p>
    </div>
    
    <!-- Tabla de participantes -->
    <main>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tablaParticipantes">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>TD</th>
                  <th>Identif..</th>
                  <th>Nombres y Apellidos</th>
                  <th>Roll</th>                  
                  <th>Carnet</th>
                  <th>Listado</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                  <tr>
                    <td><?= ++$contador ?></td>
                    <td><?= htmlspecialchars($fila["doctipo"]) ?></td>
                    <td><?= htmlspecialchars($fila["id"]) ?></td>
                    <td><?= htmlspecialchars($fila["nombres"]) ?></td>
                    <td><?= htmlspecialchars($fila["tipo2"]) ?></td>                    
                    <td><?= htmlspecialchars($fila["carnet"]) ?></td>
                    <td><?= htmlspecialchars($fila["correo"]) ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div><!-- /.table-responsive -->
        </div><!-- /.col-12 -->
      </div><!-- /.row -->
    </main>
  </div><!-- /.container -->
  
  <!-- jQuery (para las funciones de filtrado) -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Bootstrap 5 JS Bundle (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery UI JS (opcional) -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(document).ready(function() {
      // Filtrado en tiempo real para el buscador
      $("#buscador").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tablaParticipantes tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });
      
      // Filtrado por el dropdown
      $(".dropdown-item").click(function(e) {
        e.preventDefault();
        var selectedTipo = $(this).data("tipo").toLowerCase();
        var btnText = $(this).text();
        $("#dropdownTipo").text(btnText);
        
        if (selectedTipo === "all") {
          $("#tablaParticipantes tbody tr").show();
        } else {
          $("#tablaParticipantes tbody tr").each(function() {
            // Se asume que el campo "tipo2" (para filtrar) está en la quinta columna
            var rowTipo = $(this).find("td:nth-child(5)").text().toLowerCase();
            $(this).toggle(rowTipo.indexOf(selectedTipo) > -1);
          });
        }
      });
    });
  </script>
</body>
</html>
