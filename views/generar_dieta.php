<?php
session_start();

// --- INICIO: Obtención de datos y cálculos iniciales ---
// Verificar si todos los datos necesarios de los pasos anteriores de la sesión están disponibles
if (
    !isset($_SESSION['imc']) ||
    !isset($_SESSION['calculo_energetico']['vct']) ||
    !isset($_SESSION['sexo']) ||
    !isset($_SESSION['edad']) ||
    !isset($_SESSION['peso']) ||
    !isset($_SESSION['talla']) ||
    !isset($_SESSION['calculo_energetico']['nivel_actividad']) ||
    !isset($_SESSION['clasificacion'])
) {
    // Redirigir de nuevo si faltan los datos subyacentes. Ajustar la ruta según sea necesario.
    header("Location: estudioAntropometrico.php");
    exit();
}

// Extraer datos básicos del usuario de la sesión
$imc = $_SESSION['imc'];
$clasificacion_oms = $_SESSION['clasificacion'];
$peso_actual = $_SESSION['peso'];
$talla_metros = $_SESSION['talla'];
$edad = $_SESSION['edad'];
$sexo = $_SESSION['sexo'];
$nivel_actividad_original = $_SESSION['actividad'] ?? 'moderada'; // Utilizamos el valor bruto de la actividad de calcularGEB
$nivel_actividad_descriptivo = $_SESSION['calculo_energetico']['nivel_actividad'];
$geb = $_SESSION['calculo_energetico']['geb'];
$get = $_SESSION['calculo_energetico']['get1'];
$vct_calculado_inicial = $_SESSION['calculo_energetico']['vct']; // Cálculo del VCT a partir del GEB

// Obtener las preferencias del usuario a partir del formulario enviado
$preferencias_form = $_SESSION['form_preferencias']['preferencias'] ?? '';
$comentario_form = $_SESSION['form_preferencias']['comentario'] ?? '';
$objetivo_form = $_SESSION['form_preferencias']['objetivo'] ?? '';
$comidas_dia_form = $_SESSION['form_preferencias']['comidasDias'] ?? '';

// Obtener la dieta generada desde la sesión generarDietaController.php después de llamar a la API
//$dieta_generada = $_SESSION['dieta_generada'] ?? null;
//unset($_SESSION['dieta_generada']); // Limpiar después de la visualización para evitar datos obsoletos

// Procesamiento de mensajes potenciales del controlador
$mensaje = $_SESSION['mensaje_dieta_app'] ?? '';
unset($_SESSION['mensaje_dieta_app']);
$error = $_SESSION['error_dieta_app'] ?? '';
unset($_SESSION['error_dieta_app']);

// --- FIN: Adquisición de datos y cálculos iniciales ---

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Generar Dieta Personalizada - DietaIA</title>
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
    <!-- Spinner de carga -->
    <div id="loading-overlay" style="display: none;">
        <div class="spinner"></div>
        <p style="color: white; font-size: 1.2em;">Generando tu dieta personalizada...</p>
    </div>

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
            <h3 class="text-center mb-4"><i>Paso 3: Generación de dietas con IA</i></h3>
            <div>
                Patologías: <?= $_SESSION['enfermedades'] ?><br>
                Alergias: <?= $_SESSION['alergenos'] ?><br>
                Intolerancias: <?= $_SESSION['intolerancias'] ?>
            </div>
            <?php if (isset($mensaje)): ?>
                <p style="color:green;"><?= $mensaje ?></p>
            <?php elseif (isset($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>
            <form id="generar-form" action="../controllers/generar_dieta_controller.php" method="POST">
                <div class="mb-4">
                    <label for="objetivo" class="form-label"><i>Objetivo:</i></label>
                    <select class="form-select" id="objetivo" name="objetivo" required>
                        <?php
                        $default_objetivo = '';
                        if ($clasificacion_oms === "bajo peso") {
                            $default_objetivo = 'subirPeso';
                        } elseif (strpos($clasificacion_oms, 'obesidad') !== false || $clasificacion_oms === 'sobrepeso') {
                            $default_objetivo = 'bajarPeso';
                        } else {
                            $default_objetivo = 'mantenerPeso';
                        }
                        ?>
                        <option value="subirPeso" <?= ($objetivo_form === 'subirPeso' || $default_objetivo === 'subirPeso') ? 'selected' : '' ?>>Subir peso ⬆︎</option>
                        <option value="mantenerPeso" <?= ($objetivo_form === 'mantenerPeso' || $default_objetivo === 'mantenerPeso') ? 'selected' : '' ?>>Mantener peso ➡︎</option>
                        <option value="bajarPeso" <?= ($objetivo_form === 'bajarPeso' || $default_objetivo === 'bajarPeso') ? 'selected' : '' ?>>Bajar peso ⬇︎</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="comidasDias" class="form-label"><i>Número de comidas al día:</i></label>
                    <select class="form-select" name="comidasDias" id="comidasDias" required>
                        <option value="3" <?= ($comidas_dia_form == 3 || empty($comidas_dia_form)) ? 'selected' : '' ?>>3</option>
                        <option value="4" <?= ($comidas_dia_form == 4) ? 'selected' : '' ?>>4</option>
                        <option value="5" <?= ($comidas_dia_form == 5) ? 'selected' : '' ?>>5</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="preferencias" class="form-label"><i>Tipo de dieta (opcional):</i>
                        <i class="fa-solid fa-circle-question text-info" data-bs-toggle="tooltip"
                            title="Ovolactovegetariano: incluye huevos y lácteos, pero no carne ni pescado.
Vegano: excluye todos los productos de origen animal.
Cetogénica: alta en grasas y muy baja en carbohidratos.
Sin gluten: excluye alimentos que contienen gluten, como trigo, cebada y centeno.">
                        </i>
                    </label>
                    <select class="form-select" name="preferencias" id="preferencias">
                        <option value="" <?= empty($preferencias_form) ? 'selected' : '' ?>>Normal (sin restricciones especiales)</option>
                        <option value="ovolactovegetariana" <?= ($preferencias_form === 'ovolactovegetariana') ? 'selected' : '' ?>>Ovolactovegetariano</option>
                        <option value="vegana" <?= ($preferencias_form === 'vegana') ? 'selected' : '' ?>>Vegano</option>
                        <option value="cetogenica" <?= ($preferencias_form === 'cetogenica') ? 'selected' : '' ?>>Cetogénica</option>
                        <option value="sinGluten" <?= ($preferencias_form === 'sinGluten') ? 'selected' : '' ?>>Sin gluten</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="comentario" class="form-label"><i>Comentarios adicionales (opcional):</i></label>
                    <textarea name="comentario" id="comentario" class="form-control" placeholder="Ej.: No me gusta el atún, soy alérgico al maní, prefiero la comida rápida."><?= htmlspecialchars($comentario_form) ?></textarea>
                </div>

                <div class="text-start">
                    <button type="submit" name="generarDieta" class="btn btn-warning"><i class="fa-solid fa-mug-hot"></i> Generar dieta</button>
                </div><br>
                <div class="text-start">
                    <a href="gasto_energetico.php" class="btn btn-light btn-sm">
                        <i class="fa-regular fa-hand-point-left"></i> Atrás
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
<script>
    document.getElementById('generar-form').addEventListener('submit', function() {
        document.getElementById('loading-overlay').style.display = 'flex';
    });
</script>


</html>