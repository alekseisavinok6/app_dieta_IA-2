<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - Dieta-IA</title>
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
                <a href="../index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-home"></i> Volver al inicio
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container my-5">
        <div class="form-section" style="max-width: 480px;">
            <img src="../imgs/login2.png" alt="Icono" class="img-fluid float-end ms-3" style="max-width: 170px;">
            <h3 class="text-start mb-4"><i>Inicia sesión</i></h3>
            
            <form action="../controllers/login_controller.php" method="POST">
                <div class="mb-4">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</button>
                </div>
            </form>
            <div class="text-center mt-3">
                ¿No tienes una cuenta? <a href="registro.php">Registrarse</a>
            </div>
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