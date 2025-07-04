<?php

require_once '../db.php';

// Recoge y limpia datos del formulario
function limpiar($dato) {
    return htmlspecialchars(trim($dato));
}

$nombre = limpiar($_POST['nombre'] ?? '');
$apellido = limpiar($_POST['apellido'] ?? '');
$correo = limpiar($_POST['correo'] ?? '');
$peso = floatval($_POST['peso'] ?? 0);
$talla = floatval($_POST['talla'] ?? 0);
$edad = intval($_POST['edad'] ?? 0);
$sexo = limpiar($_POST['sexo'] ?? '');
$alergenos = limpiar($_POST['alergenos'] ?? '');
$intolerancias = limpiar($_POST['intolerancias'] ?? '');
$enfermedades = limpiar($_POST['enfermedades'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

// Validaciones básicas
$errores = [];

if (!$nombre || !$apellido || !$correo || !$peso || !$talla || !$edad || !$sexo || !$contrasena || !$confirmar_contrasena) {
    $errores[] = "Todos los campos obligatorios deben estar completos.";
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Correo electrónico no válido.";
}

if ($contrasena !== $confirmar_contrasena) {
    $errores[] = "Las contraseñas no coinciden.";
}

if (!in_array($sexo, ['hombre', 'mujer'])) {
    $errores[] = "Sexo biológico no válido.";
}

// Convertir talla de cm a metros
if (!empty($talla)) {
    $talla = $talla / 100;
}

// ¿Correo ya registrado?
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $errores[] = "El correo ya está registrado.";
}
$stmt->close();

// Si hay errores, los mostramos
if (!empty($errores)) {
    echo "<h3>Errores en el registro:</h3><ul>";
    foreach ($errores as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ul><a href='../views/registro.php'>Volver al registro</a>";
    exit();
}

// Encriptar la contraseña
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar en la base de datos
$stmt = $conn->prepare("INSERT INTO usuarios 
    (nombre, apellido, correo, peso, talla, edad, sexo, alergenos, intolerancias, enfermedades, contrasena_hash) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssddisssss",
    $nombre,
    $apellido,
    $correo,
    $peso,
    $talla,
    $edad,
    $sexo,
    $alergenos,
    $intolerancias,
    $enfermedades,
    $contrasena_hash
);

if ($stmt->execute()) {
    // Registro exitoso
    header("Location: ../views/login.php");
    exit;
} else {
    echo "Error al registrar usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
