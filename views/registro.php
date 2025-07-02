<!-- registro.php -->
<?php
// Aquí podrías incluir control de sesión si fuera necesario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - DietaIA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="logo.png" type="image/png">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 1rem 0;
            font-size: 0.9rem;
        }
        .form-section {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../imgs/logo.png" alt="DietaIA" width="40" class="me-2">
                <strong>DietaIA</strong>
            </a>
            <div class="ms-auto">
                <a href="../index.php" class="btn btn-outline-secondary">
                    <i class="fa fa-home"></i> Volver al inicio
                </a>
            </div>
        </div>
    </nav>

    <!-- CUERPO PRINCIPAL -->
    <main>
        <div class="container my-5">
            <div class="form-section">
                <h2 class="text-center mb-4">Crea tu cuenta</h2>
                <p class="text-center text-muted mb-4">
                    Para personalizar tu dieta necesitamos conocer algunos datos personales y de salud. ¡Tu información estará segura con nosotros!
                </p>

                <form action="registro_controller.php" method="POST">
                    <!-- Nombre y Apellido -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>

                    <!-- Peso, Talla, Edad -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="peso" name="peso" placeholder="(ej. 75)" required>
                        </div>
                        <div class="col-md-4">
                            <label for="talla" class="form-label">Talla (cm)</label>
                            <input type="number" step="0.1" class="form-control" id="talla" name="talla" placeholder="(ej. 175)" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad" required>
                        </div>
                    </div>

                    <!-- Sexo -->
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo biológico</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="">Selecciona</option>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                        </select>
                    </div>

                    <!-- Alérgenos -->
                    <div class="mb-3">
                        <label for="alergenos" class="form-label">Alérgenos</label>
                        <input type="text" class="form-control" id="alergenos" name="alergenos" placeholder="Ej: gluten, marisco... o escribe 'ninguna'" required>
                    </div>

                    <!-- Intolerancias -->
                    <div class="mb-3">
                        <label for="intolerancias" class="form-label">Intolerancias</label>
                        <input type="text" class="form-control" id="intolerancias" name="intolerancias" placeholder="Ej: lactosa, fructosa... o escribe 'ninguna'" required>
                    </div>

                    <!-- Enfermedades -->
                    <div class="mb-3">
                        <label for="enfermedades" class="form-label">Enfermedades</label>
                        <input type="text" class="form-control" id="enfermedades" name="enfermedades" placeholder="Ej: diabetes, hipertensión... o escribe 'ninguna'" required>
                    </div>

                    <!-- Contraseña y Confirmar contraseña -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmar_contrasena" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
                        </div>
                    </div>

                    <!-- Botón de Registro -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-user-plus me-2"></i> Registrarse
                        </button>
                    </div>

                    <!-- ¿Ya tienes cuenta? -->
                    <div class="text-center">
                        ¿Ya tienes una cuenta?
                        <a href="login.php">Iniciar sesión</a>
                    </div>
                </form>
            </div>
        </div>
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
