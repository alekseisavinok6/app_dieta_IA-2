<?php
// db.php - Archivo de conexión a la base de datos

$host = '127.0.0.1';
$usuario = 'root';       // Cambia si usas otro usuario
$contrasena = '';        // Cambia si tienes contraseña en tu MySQL
$base_datos = 'dieta_app2';

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Opcional: establecer codificación utf8
$conn->set_charset("utf8");