<?php
session_start();
require "rene/conexion.php"; // Se espera que en este archivo se defina $conec

// ----- Lógica de Autenticación -----
$loginError = "";

// Si aún no se ha iniciado sesión, se muestra el formulario de login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        // Validar credenciales (cámbialas según tus necesidades)
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if ($username === "RENE" && $password === "198906") {
            $_SESSION['loggedin'] = true;
            // Redireccionar para evitar reenvío del formulario de login
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $loginError = "Usuario o contraseña incorrectos.";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
   
    <head>
        <meta charset="UTF-8">
        <title>Login - Asignar Tipo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>


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


        <div class="container d-flex flex-column align-items-center" style="max-width: 400px;">
  <div class="text-center mb-3">
    <img src="img/AsignaciónRoles.jpg" alt="Usuario" class="img-fluid login-img" style="max-width: 80%;">
  </div>

  <?php if (!empty($loginError)): ?>
    <div class="alert alert-danger text-center"><?php echo htmlspecialchars($loginError); ?></div>
  <?php endif; ?>

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="w-100">
    <input type="hidden" name="login" value="1">
    <div class="mb-3">
      <label for="username" class="form-label">Usuario</label>
      <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
  </form>
</div>

    </div>

  <!-- Bootstrap 5 JS Bundle (incluye Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php
    exit;
}
// ----- Fin Lógica de Autenticación -----


// ----- Lógica de Asignación de Tipo ----- 
$message = "";

// Procesar el formulario de asignación si se envía (excluyendo el login)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['login'])) {
    $participante_id = isset($_POST['participante_id']) ? intval($_POST['participante_id']) : 0;
    $tipo_id = isset($_POST['tipo_id']) ? intval($_POST['tipo_id']) : 0;

    if ($participante_id > 0 && $tipo_id > 0) {
        $sql = "INSERT INTO participante_tipo (participante_id, tipo_id) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE participante_id = participante_id";
        $stmt = $conec->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $participante_id, $tipo_id);
            if ($stmt->execute()) {
                $message = "Tipo asignado correctamente al participante.";
            } else {
                $message = "Error al asignar el tipo: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error en la preparación de la consulta: " . $conec->error;
        }
    } else {
        $message = "Selecciona un participante y un tipo válidos.";
    }
}

// Obtener la lista de participantes (id y nombres)
$participantes = [];
$result = $conec->query("SELECT id, nombres FROM participantes ORDER BY nombres ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $participantes[] = $row;
    }
    $result->free();
} else {
    $message .= " Error al obtener participantes: " . $conec->error;
}

// Obtener la lista de tipos (id y nombre)
$tipos = [];
$result = $conec->query("SELECT id, nombre FROM tipo ORDER BY nombre ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tipos[] = $row;
    }
    $result->free();
} else {
    $message .= " Error al obtener tipos: " . $conec->error;
}

$conec->close();
?>

<?php
// asignar_tipo.php

require "rene/conexion.php"; // Se espera que en este archivo se defina $conec

$message = "";

// Procesar el formulario de asignación
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['login'])) {
    $participante_id = isset($_POST['participante_id']) ? intval($_POST['participante_id']) : 0;
    $tipo_id = isset($_POST['tipo_id']) ? intval($_POST['tipo_id']) : 0;

    if ($participante_id > 0 && $tipo_id > 0) {
        $sql = "INSERT INTO participante_tipo (participante_id, tipo_id) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE participante_id = participante_id";
        $stmt = $conec->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $participante_id, $tipo_id);
            if ($stmt->execute()) {
                $message = "Tipo asignado correctamente al participante.";
            } else {
                $message = "Error al asignar el tipo: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error en la preparación de la consulta: " . $conec->error;
        }
    } else {
        $message = "Selecciona un participante y un tipo válidos.";
    }
}

// Obtener la lista de participantes (id y nombres)
$participantes = [];
$result = $conec->query("SELECT id, nombres FROM participantes ORDER BY nombres ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $participantes[] = $row;
    }
    $result->free();
} else {
    $message .= " Error al obtener participantes: " . $conec->error;
}

// Obtener la lista de tipos (id y nombre)
$tipos = [];
$result = $conec->query("SELECT id, nombre FROM tipo ORDER BY nombre ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tipos[] = $row;
    }
    $result->free();
} else {
    $message .= " Error al obtener tipos: " . $conec->error;
}

$conec->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Tipo a Participante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <a href="rene/logout.php" class="btn btn-secondary mb-3">Cerrar Sesión</a>
        <h1 class="mb-4">Asignar Tipo a Participante</h1>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="mb-3">
                        <label for="participante_id" class="form-label">Selecciona el participante:</label>
                        <select name="participante_id" id="participante_id" class="form-select" required>
                            <option value="">-- Selecciona un participante --</option>
                            <?php foreach ($participantes as $p): ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nombres']."(".$p['id'].")"); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Área para mostrar los tipos ya asignados -->
                    <div id="assigned-types" class="mb-3"></div>
                    
                    <div class="mb-3">
                        <label for="tipo_id" class="form-label">Selecciona el tipo:</label>
                        <select name="tipo_id" id="tipo_id" class="form-select" required>
                            <option value="">-- Selecciona un tipo --</option>
                            <?php foreach ($tipos as $t): ?>
                                <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Tipo</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Al cambiar el participante, se consulta vía AJAX los tipos ya asignados y se actualiza la UI
    document.getElementById('participante_id').addEventListener('change', function() {
        var participanteId = this.value;
        var tipoSelect = document.getElementById('tipo_id');
        var assignedTypesDiv = document.getElementById('assigned-types');
        
        if (participanteId) {
            fetch('rene/get_assigned_types.php?participante_id=' + participanteId)
            .then(response => response.json())
            .then(data => {
                // data es un arreglo de objetos con { id, nombre } de cada tipo asignado
                // Primero, se habilitan todas las opciones del select
                for (let option of tipoSelect.options) {
                    option.disabled = false;
                }
                // Actualizar el div con los tipos asignados (si hay)
                if (data.length > 0) {
                    let assignedNames = data.map(item => item.nombre);
                    assignedTypesDiv.innerHTML = '<div class="alert alert-secondary">Tipos asignados: ' + assignedNames.join(', ') + '</div>';
                    
                    // Deshabilitar en el select las opciones que ya han sido asignadas
                    for (let option of tipoSelect.options) {
                        if (data.some(item => item.id == option.value)) {
                            option.disabled = true;
                        }
                    }
                } else {
                    assignedTypesDiv.innerHTML = '<div class="alert alert-info">No hay tipos asignados.</div>';
                }
            })
            .catch(error => {
                console.error('Error al obtener los tipos asignados:', error);
                assignedTypesDiv.innerHTML = '<div class="alert alert-danger">Error al obtener los tipos asignados.</div>';
            });
        } else {
            // Si no se ha seleccionado ningún participante, se limpia el div y se habilitan todas las opciones
            assignedTypesDiv.innerHTML = '';
            for (let option of tipoSelect.options) {
                option.disabled = false;
            }
        }
    });
    </script>
</body>
</html>
