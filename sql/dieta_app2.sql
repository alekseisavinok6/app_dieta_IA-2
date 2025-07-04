CREATE DATABASE dieta_app2;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    correo VARCHAR(100) UNIQUE,
    peso DECIMAL(5,2),
    talla DECIMAL(5,2),
    edad INT,
    sexo ENUM('hombre', 'mujer'),
    alergenos TEXT,
    intolerancias TEXT,
    enfermedades TEXT,
    contrasena_hash VARCHAR(255),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);