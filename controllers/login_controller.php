<?php
session_start();
require_once '../db.php';

// Recoger datos del formulario
$correo = trim($_POST['correo'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';

if (empty($correo) || empty($contrasena)) {
    echo "<p>Por favor, completa todos los campos.</p>";
    echo "<a href='../views/login.php'>Volver</a>";
    exit();
}

// Buscar al usuario por correo
$stmt = $conn->prepare(
    "SELECT 
    id, 
    nombre, 
    apellido, 
    correo, 
    contrasena_hash, 
    peso, 
    peso_ideal, 
    talla, 
    edad, 
    sexo, 
    alergenos, 
    intolerancias, 
    enfermedades, 
    clasificacion, 
    actividad,
    imc, 
    geb,
    get1,
    vct,
    fecha_registro 
    FROM usuarios 
    WHERE correo = ?"
    );
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // Verificar contraseña
    if (password_verify($contrasena, $usuario['contrasena_hash'])) {

        // Guardar datos en la sesión
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['apellido'] = $usuario['apellido'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['peso'] = $usuario['peso'];
        $_SESSION['peso_ideal'] = $usuario['peso_ideal'];
        $_SESSION['clasificacion'] = $usuario['clasificacion'];
        $_SESSION['actividad'] = $usuario['actividad'];
        $_SESSION['talla'] = $usuario['talla'];
        $_SESSION['edad'] = $usuario['edad'];
        $_SESSION['sexo'] = $usuario['sexo'];
        $_SESSION['alergenos'] = $usuario['alergenos'];
        $_SESSION['intolerancias'] = $usuario['intolerancias'];
        $_SESSION['enfermedades'] = $usuario['enfermedades'];
        $_SESSION['imc'] = $usuario['imc'];
        $_SESSION['calculo_energetico']['geb'] = $usuario['geb'];
        $_SESSION['calculo_energetico']['get1'] = $usuario['get1'];
        $_SESSION['calculo_energetico']['vct'] = $usuario['vct'];
        $_SESSION['fecha_registro'] = $usuario['fecha_registro'];

        // Redirigir al index.php
        header("Location: ../index.php");
        exit();
    } else {
        // Contraseña incorrecta
        echo "<p>Contraseña incorrecta.</p>";
        echo "<a href='../views/login.php'>Volver</a>";
        exit();
    }
} else {
    // Usuario no encontrado
    echo "<p>No se encontró una cuenta con ese correo.</p>";
    echo "<a href='../views/login.php'>Volver</a>";
    exit();
}

$stmt->close();
$conn->close();
