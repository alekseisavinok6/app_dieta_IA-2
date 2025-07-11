<?php
session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Usuario - Dieta-IA</title>
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
                <img src="../imgs/logo-3-2.png" alt="Dieta-IA" width="140" class="me-3">
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
                <img src="../imgs/dashboard.png" alt="Icono" class="img-fluid float-end ms-3" style="max-width: 170px;">
                <h3 class="text-start"><i class="fa-regular fa-id-card"></i> Información personal:</h3><br>
                <div>Alta: <i><?= $_SESSION['fecha_registro']; ?></i></div><br> 
                <div>Id: <i><?= $_SESSION['id']; ?></i></div>
                <div>Nombre: <i><?= $_SESSION['nombre']; ?></i></div>
                <div>Apellido: <i><?= $_SESSION['apellido']; ?></i></div>
                <div>Correo: <i><?= $_SESSION['correo']; ?></i></div>
                <div>Edad: <i><?= $_SESSION['edad']; ?></i></div>
                <div>Talla: <i><?= $_SESSION['talla']; ?></i></div>
                <div>Peso: <i><?= $_SESSION['peso']; ?></i></div>
                <div>Peso ideal: <i><?= $_SESSION['peso_ideal']; ?></i></div>
                <div>Clasificación: <i><?= $_SESSION['clasificacion']; ?></i></div>    
                <div>Nivel de actividad: <i><?= $_SESSION['actividad']; ?></i></div>
                <div>Sexo biológico: <i><?= $_SESSION['sexo']; ?></i></div>
                <div>Alergenos: <i><?= $_SESSION['alergenos']; ?></i></div>
                <div>Intolerancias: <i><?= $_SESSION['intolerancias']; ?></i></div>
                <div>Enfermedades: <i><?= $_SESSION['enfermedades']; ?></i></div>
                <div>IMC: <i><?= $_SESSION['imc']; ?></i></div>
                <div>GEB: <i><?= $_SESSION['calculo_energetico']['geb']; ?></i></div>  
                <div>GET: <i><?= $_SESSION['calculo_energetico']['get1']; ?></i></div>  
                <div>VCT: <i><?= $_SESSION['calculo_energetico']['vct']; ?></i></div>   
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