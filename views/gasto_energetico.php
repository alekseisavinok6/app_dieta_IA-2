<?php
session_start();
require_once '../db.php';

$mensaje = $error = "";
$peso = $_SESSION['peso'] ?? '';
$talla = $_SESSION['talla'] ?? '';
$edad = $_SESSION['edad'] ?? '';
$sexo = $_SESSION['sexo'] ?? '';
$actividad = $_SESSION['actividad'] ?? '';
$peso_ideal = $_SESSION['peso_ideal'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $edad = intval($_POST['edad'] ?? 0);
    $sexo = $_POST['sexo'] ?? '';
    $actividad = $_POST['actividad'] ?? '';

    // Cálculo de gásto energético basal (GEB)
    if ($peso && $talla && $edad && $sexo && $actividad) {
        // Fórmula Harris-Benedict
        if ($sexo === 'hombre') {
            $geb = 66.5 + (13.75 * $peso) + (5.003 * $talla * 100) - (6.775 * $edad);
        } else {
            $geb = 655.1 + (9.563 * $peso) + (1.850 * $talla * 100) - (4.676 * $edad);
        }

        // Factores de actividad
        $niveles = [
            'sedentario' => ['factor' => 1.2, 'desc' => 'Sedentario'],
            'ligera' => ['factor' => 1.375, 'desc' => 'Actividad ligera'],
            'moderada' => ['factor' => 1.55, 'desc' => 'Actividad moderada'],
            'intensa' => ['factor' => 1.725, 'desc' => 'Actividad intensa'],
            'muy_intensa' => ['factor' => 1.9, 'desc' => 'Actividad muy intensa'],
        ];

        $factor = $niveles[$actividad]['factor'] ?? 1;
        $nivel_actividad = $niveles[$actividad]['desc'] ?? 'Desconocido';

        // Calcular Gasto Energético Total (GET)
        $get1 = $geb * $factor;

        // Calcular VCT (usando peso ideal)
        if ($peso_ideal !== null) {
            if ($sexo === 'hombre') {
                $vct = (66.5 + (13.75 * $peso_ideal) + (5 * ($talla * 100)) - (6.75 * $edad)) * $factor;
            } elseif ($sexo === 'mujer') {
                $vct = (655 + (9.563 * $peso_ideal) + (1.850 * ($talla * 100)) - (4.676 * $edad)) * $factor;
            }
        }

        // Guardar en sesión
        $_SESSION['edad'] = $edad;
        $_SESSION['sexo'] = $sexo;
        $_SESSION['actividad'] = $actividad;
        $_SESSION['calculo_energetico'] = [
            'geb' => round($geb, 2),
            'get1' => round($get1, 2),
            'vct' => round($vct, 2),
            'nivel_actividad' => $nivel_actividad
        ];


        if ($conn->connect_error) {
            $error = "Error de conexión con la base de datos: " . $conn->connect_error;
        } else {
            $id = $_SESSION['id'];
            $stmt = $conn->prepare(
                "UPDATE usuarios
                SET 
                edad = ?, 
                sexo = ?, 
                actividad = ?, 
                geb = ?, 
                get1 = ?,
                vct = ?
                WHERE id = ?"
            );
            $stmt->bind_param(
                "issdddi",
                $edad,
                $sexo,
                $actividad,
                $geb,
                $get1,
                $vct,
                $id
            );
            if ($stmt->execute()) {
                //$mensaje .= "Datos actualizados correctamente en la base de datos.";
            } else {
                $error = "Error al actualizar los datos: " . $stmt->error;
            }

            $stmt->close();
            //$conn->close();
        }

        //$mensaje = "Cálculo realizado correctamente.";
    } else {
        $error = "Por favor, completa todos los campos correctamente.";
    }
}

$geb = $_SESSION['calculo_energetico']['geb'] ?? null;
$get1 = $_SESSION['calculo_energetico']['get1'] ?? null;
$vct = $_SESSION['calculo_energetico']['vct'] ?? null;
$nivel_actividad = $_SESSION['calculo_energetico']['nivel_actividad'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cálculo GEB, GET y VCT - Dieta-IA</title>
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
                <img src="../imgs/logo-3-2.png" alt="Dieta-IA" width="140" class="me-3">
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
            <h3 class="text-center mb-4"><i>Paso 2: Cálculo del gasto energético</i>
            <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" title="Estimación del gasto calórico según edad, peso, altura y actividad física"></i>
            </h3>
            <?php if (isset($mensaje)): ?>
                <p style="color:green;"><?= $mensaje ?></p>
            <?php elseif (isset($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <form action="gasto_energetico.php" method="POST">
                <div class="mb-4">
                    <label for="edad" class="form-label"><i>Edad:</i></label>
                    <input type="number" name="edad" id="edad" class="form-control" required
                        value="<?= $_SESSION['edad'] ?>">
                </div>

                <div class="mb-4">
                    <label for="sexo" class="form-label"><i>Sexo biológico:</i></label>
                    <select class="form-select" id="sexo" name="sexo" required>
                        <option value="">Selecciona</option>
                        <option value="hombre" <?= $sexo === 'hombre' ? 'selected' : '' ?>>Hombre 👨</option>
                        <option value="mujer" <?= $sexo === 'mujer' ? 'selected' : '' ?>>Mujer 👧</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="actividad" class="form-label"><i>Nivel de actividad física:</i></label>
                    <select class="form-select" name="actividad" required>
                        <option value="">Seleccione...</option>
                        <option value="sedentario" <?= $actividad === 'sedentario' ? 'selected' : '' ?>>Sedentario 🧘🏽‍♂️</option>
                        <option value="ligera" <?= $actividad === 'ligera' ? 'selected' : '' ?>>Actividad ligera 🤹🏻‍♂️</option>
                        <option value="moderada" <?= $actividad === 'moderada' ? 'selected' : '' ?>>Actividad moderada 🤸🏻‍♂️</option>
                        <option value="intensa" <?= $actividad === 'intensa' ? 'selected' : '' ?>>Actividad intensa 🚴🏻‍♀️</option>
                        <option value="muy intensa" <?= $actividad === 'muy_intensa' ? 'selected' : '' ?>>Actividad muy intensa 🚴🏻‍♀️🚴🏻‍♀️</option>
                    </select>
                </div>

                <div><i>GEB:</i> <?= number_format($geb, 2, ',', '.') ?> kcal/día
                <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" 
                title="Gasto Energético Basal (GEB): calorías que necesitas en reposo"></i>
                </div>
                <div><i>GET:</i> <?= number_format($get1, 2, ',', '.') ?> kcal/día
                <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" 
                title="Gasto Energético Total (GET): GEB multiplicado por tu nivel de actividad física"></i>
                </div>
                <div><i>VCT:</i> <?= number_format($vct, 2, ',', '.') ?> kcal/día
                <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip" 
                title="Valor Calórico Total (VCT): estimación de calorías diarias usando tu peso ideal"></i>
                </div><br>

                <div class="text-start">
                    <button type="submit" class="btn btn-warning"><i class="fa-solid fa-calculator"></i> Calcular</button>
                </div><br>
                <div class="text-start">
                    <a href="generar_dieta.php" class="btn btn-light btn-sm">
                        <i class="fa-regular fa-hand-point-right"></i> Siguiente paso
                    </a>
                </div><br>
                <div class="text-start">
                    <a href="estudio_antropometrico.php" class="btn btn-light btn-sm">
                        <i class="fa-regular fa-hand-point-left"></i> Atrás
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="text-center p-3">
            <p class="mb-1">© 2025 <strong>Dieta-IA</strong>. Reservados todos los derechos.</p>
            📞 +34 123 456 789 | 📧 info@dieta-ia.com | 📍 Calle Ficticia 123, 28013 Madrid, España
        </div>
    </footer>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>