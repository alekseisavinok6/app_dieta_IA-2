<?php
session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Usuario - DietaIA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="shortcut icon" href="../imgs/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../imgs/logo.png" alt="DietaIA" width="46" class="me-3">
                <strong>DietaIA</strong>
            </a>
            <div class="ms-auto">
                <a href="../index.php" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-home"></i> Volver al inicio
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
        <div class="container my-5">
            <div class="form-section">
                <h3 class="text-center">Información personal:</h3>
                <div>Id: <i><?= $_SESSION['usuario_id']; ?></i></div>
                <div>Nombre: <i><?= $_SESSION['nombre']; ?></i></div>
                <div>Apellido: <i><?= $_SESSION['apellido']; ?></i></div>
                <div>Correo: <i><?= $_SESSION['correo']; ?></i></div>
                <div>Peso: <i><?= $_SESSION['peso']; ?></i></div>
                <div>Talla: <i><?= $_SESSION['talla']; ?></i></div>
                <div>Edad: <i><?= $_SESSION['edad']; ?></i></div>
                <div>Sexo biológico: <i><?= $_SESSION['sexo']; ?></i></div>
                <div>Alergenos: <i><?= $_SESSION['alergenos']; ?></i></div>
                <div>Intolerancias: <i><?= $_SESSION['intolerancias']; ?></i></div>
                <div>Enfermedades: <i><?= $_SESSION['enfermedades']; ?></i></div>
                <div>Alta: <i><?= $_SESSION['fecha_registro']; ?></i></div>                
            </div>
        </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-1">© 2025 <strong>DietaIA</strong>. Reservados todos los derechos.</p>
            <p class="mb-0">
                <i class="fa fa-phone"></i> +34 123 456 789 &nbsp; | &nbsp;
                <i class="fa fa-envelope"></i> info@dieta-ia.com &nbsp; | &nbsp;
                <i class="fa fa-map-marker-alt"></i> Calle Ficticia 123, 28013 Madrid, España
            </p>
        </div>
    </footer>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>