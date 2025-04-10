<?php 
require('fpdf.php');
session_start();

if ($_SESSION["idencargado"] == "X") {
    header("Location: ../index.php");
    exit();
}

if ($_SESSION["idencargado"] == "B") {

    require "../rene/conexion.php";

    // Asegurar que la conexión use UTF-8
    $conec->set_charset("utf8");

    class PDF extends FPDF
    {
        protected $nombre;
        protected $cedula;
        protected $tipo;
        protected $correo;
        protected $calidad;
        protected $DoctipoLargo;

        public function loadData($id, $conec, $rol)
        {
            $id = intval($id);
            $query = "SELECT id, nombres, doctipo, correo FROM participantes WHERE id = ?";
            if ($stmt = $conec->prepare($query)) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $this->nombre  = utf8_decode($row['nombres']);
                    $this->cedula  = $row['id'];
                    $this->tipo    = $row['doctipo'];
                    $this->correo  = $row['correo'];
                    $this->calidad = utf8_decode($rol);
                } else {
                    die("Error: No se encontraron datos para el participante con ID $id.");
                }
                $stmt->close();
            } else {
                die("Error preparando la consulta: " . $conec->error);
            }

            if ($this->tipo == 'CC') {
                $this->DoctipoLargo = utf8_decode("Cédula de Ciudadanía número ");
            } elseif ($this->tipo == 'TI') {
                $this->DoctipoLargo = utf8_decode("Tarjeta de Identidad número ");
            } else {
                $this->DoctipoLargo = utf8_decode("documento número ") . $this->correo;
            }

            if ($this->calidad == 'DOCENTEU') {
                $this->calidad = utf8_decode("CONFERENCISTA en representación de la Universidad de Nariño,");
            }
        }

        function Header()
        {   
            $fondo = '../img/diplomaFondo2.jpg';
            if (!file_exists($fondo)) {
                error_log("Error: No se encontró la imagen de fondo: $fondo");
            }
            $this->Image($fondo, 0, 0, 279.2);

            $qrPath = '../qr/temp/temp.png';
            if (!file_exists($qrPath)) {
                error_log("Error: No se encontró la imagen QR en $qrPath");
                $qrPath = '../img/placeholder.png';
            }
            $this->Image($qrPath, 231, 32, 34);

            $this->AddFont("Concept Medium", '', "Concept Medium.php");
            $this->SetFont('Arial', 'B', 22);
            $this->Cell(80);            
            $this->Cell(95, 141, $this->nombre, 0, 1, 'C');

            $this->AddFont("Montserrat", '', "Montserrat-Regular.php");
            $this->SetFont('Montserrat', '', 11);
            $this->Cell(255, -128, utf8_decode("Identificado(a) con ") . $this->DoctipoLargo . $this->cedula, 0, 1, 'C');
            $this->Cell(255, 138, utf8_decode("Participó en calidad de ") . $this->calidad . utf8_decode(" en el "), 0, 1, 'C');
            $this->Ln(20);
        }
    }

    $pdf = new PDF('L', 'mm', 'letter');
    if (isset($_SESSION['id']) && isset($_SESSION['rol']) && !empty($_SESSION['rol'])) {
        $pdf->loadData($_SESSION['id'], $conec, $_SESSION['rol']);
    } else {
        die("No se encontró el ID del participante o el rol en la sesión.");
    }

    $tituloPDF = utf8_decode("CERTIFICACIÓN(" . $_SESSION['id'] . ") XI Congreso Internacional de Derecho Constitucional 2023 - UDENAR");
    $pdf->SetTitle($tituloPDF);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 12);
    $nombreArchivo = utf8_decode("CERTIFICACIÓN(" . $_SESSION['id'] . ") XI Congreso Internacional de Derecho Constitucional 2023-UDENAR.pdf");
    $pdf->Output('', $nombreArchivo);
}
session_destroy();
?>
