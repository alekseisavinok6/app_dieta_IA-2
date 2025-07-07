<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['peso_ideal'], $_SESSION['imc'], $_SESSION['clasificacion']) && isset($_SESSION['id'])) {

    if (!$conn->connect_error) {
        $stmt = $conn->prepare(
            "SELECT peso, talla, imc, peso_ideal, clasificacion 
            FROM usuarios 
            WHERE id = ?"
        );
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($row = $resultado->fetch_assoc()) {
            $_SESSION['peso'] = $row['peso'];
            $_SESSION['talla'] = $row['talla'];
            $_SESSION['imc'] = round($row['imc'], 2);
            $_SESSION['peso_ideal'] = round($row['peso_ideal'], 2);
            $_SESSION['clasificacion'] = $row['clasificacion'];
        }

        $stmt->close();
        //$conn->close();
    }
}

// Recoger datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $peso = floatval($_POST['peso'] ?? 0);
    $talla = floatval($_POST['talla'] ?? 0);

    // Cálculo del IMC y peso ideal
    if ($peso && $talla) {
        $imc = $peso / pow($talla, 2);
        $peso_ideal = 22 * pow($talla, 2);

        // Clasificación según OMS
        if ($imc < 18.5) {
            $clasificacion = "bajo peso";
        } elseif ($imc < 25) {
            $clasificacion = "peso normal";
        } elseif ($imc < 30) {
            $clasificacion = "sobrepeso";
        } elseif ($imc < 35) {
            $clasificacion = "obesidad grado I";
        } elseif ($imc < 40) {
            $clasificacion = "obesidad grado II";
        } else {
            $clasificacion = "obesidad grado III";
        }

        // Guardar en sesión
        $_SESSION['peso'] = $peso;
        $_SESSION['talla'] = $talla;
        $_SESSION['imc'] = round($imc, 2);
        $_SESSION['peso_ideal'] = round($peso_ideal, 2);
        $_SESSION['clasificacion'] = $clasificacion;

        // Guardar en base de datos
        $id = $_SESSION['id'];

        if ($conn->connect_error) {
            $error = "Error de conexión: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare(
                "UPDATE usuarios
                    SET peso = ?, 
                    talla = ?, 
                    imc = ?, 
                    peso_ideal = ?, 
                    clasificacion = ? 
                    WHERE id = ?"
            );
            $stmt->bind_param("ddddsi", $peso, $talla, $imc, $peso_ideal, $clasificacion, $id);

            if (!$stmt->execute()) {
                $error = "Error al guardar los datos: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }

        //$mensaje = "Estudio antropométrico calculado correctamente.";
    } else {
        $error = "Por favor, ingresa peso y talla válidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estudio Antropométrico - DietaIA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="shortcut icon" href="../imgs/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
</head>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../imgs/logo-2.png" alt="DietaIA" width="46" class="me-3">
                <i class="logo">DietaIA</i>
            </a>
            <div class="ms-auto">
                <a href="../index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i> Volver al inicio
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container my-5">
        <div class="form-section" style="max-width: 450px;">
            <h3 class="text-center mb-4"><i>Paso 1: Estudio antropométrico</i>
            <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" title="Medición de tu peso, talla e IMC para calcular tus necesidades nutricionales"></i>
            </h3>
            <?php if (isset($mensaje)): ?>
                <p style="color:green;"><?= $mensaje ?></p>
            <?php elseif (isset($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <form action="estudio_antropometrico.php" method="POST">
                <div class="mb-4">
                    <label for="peso" class="form-label"><i>Peso (kg):</i></label>
                    <input type="number" step="0.01" name="peso" id="peso" class="form-control" required
                        value="<?= $_SESSION['peso'] ?>">
                </div>

                <div class="mb-4">
                    <label for="talla" class="form-label"><i>Talla (m):</i></label>
                    <input type="number" step="0.01" name="talla" id="talla" class="form-control" required
                        value="<?= $_SESSION['talla'] ?>">
                </div>

                <div>
                    <i>IMC:</i> 
                    <?= $_SESSION['imc'] ?>
                    <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" title="Índice de Masa Corporal (IMC) es la relación entre tu peso y tu altura"></i>
                </div>
                <div>
                    <i>Peso ideal:</i> 
                    <?= $_SESSION['peso_ideal'] ?> kg
                    <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" title="Peso estimado en el que se considera que tienes un estado de salud óptimo"></i>
                </div>
                <div>
                    <i>Clasificación OMC:</i> 
                    <?= ucfirst($_SESSION['clasificacion']) ?>
                    <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" title="Categoría de tu peso según la Organización Mundial de la Salud (OMS) (ej: normal, sobrepeso, obesidad...)"></i>
                </div><br>
                <div class="text-start">
                    <button type="submit" class="btn btn-warning"><i class="fa-solid fa-calculator"></i> Calcular</button>
                </div><br>
                <div class="text-start">
                    <a href="gasto_energetico.php" class="btn btn-light btn-sm">
                    <i class="fa-regular fa-hand-point-right"></i> Siguiente paso
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="text-center p-3">
            <p class="mb-1">© 2025 <strong>DietaIA</strong>. Reservados todos los derechos.</p>
            📞 +34 123 456 789 | 📧 info@dieta-ia.com | 📍 Calle Ficticia 123, 28013 Madrid, España
        </div>
    </footer>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>