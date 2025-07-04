<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietaIA - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="imgs/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="imgs/logo.png" alt="DietaIA" width="46" class="me-3">
                <strong>DietaIA</strong>
            </a>
            <div class="ms-auto">
                <a href="views/registro.php" class="btn btn-outline-primary me-2">
                    <i class="fa fa-user-plus"></i> Registrarse
                </a>
                <a href="views/login.php" class="btn btn-primary">
                    <i class="fa fa-sign-in-alt"></i> Iniciar sesión
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main>
        <section class="hero">
            <div class="container">
                <h1 class="display-5">Bienvenido a DietaIA</h1>
                <p class="lead mt-3">
                    Tu asistente inteligente para generar dietas personalizadas de forma fácil, rápida y adaptada a tus necesidades.
                </p>
                <p class="mt-4">
                    Con DietaIA puedes:
                </p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-check text-success me-2"></i> Crear planes alimenticios adaptados a tus objetivos</li>
                    <li><i class="fa fa-check text-success me-2"></i> Tener en cuenta alergias, intolerancias y enfermedades</li>
                    <li><i class="fa fa-check text-success me-2"></i> Seguir un estilo de vida saludable basado en la dieta mediterránea</li>
                </ul>
                <a href="views/registro.php" class="btn btn-lg btn-success mt-4">
                    <i class="fa fa-rocket me-2"></i> ¡Empieza ahora!
                </a>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>