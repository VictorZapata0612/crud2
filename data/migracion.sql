
CREATE DATABASE CRUD;

use CRUD;

CREATE TABLE Estudiante (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    identificacion INT(50) NOT NULL,
    genero VARCHAR(255) NOT NULL,
    nombre_padre VARCHAR(255) NOT NULL,
    nombre_madre VARCHAR(255) NOT NULL,
    telefono INT(50) NOT NULL,
    telefono_acudiente INT(50) NOT NULL,
    eps VARCHAR(255) NOT NULL,
    grado INT(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);