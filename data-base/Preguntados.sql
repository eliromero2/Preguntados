CREATE DATABASE IF NOT EXISTS preguntados;

USE preguntados;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
                       id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       nombre_completo VARCHAR(255) NOT NULL,
                       ano_nacimiento INT DEFAULT NULL,
                       sexo ENUM('Masculino', 'Femenino', 'Prefiero no decirlo') DEFAULT NULL,
                       pais VARCHAR(50) DEFAULT NULL,
                       ciudad VARCHAR(50) DEFAULT NULL,
                       mail VARCHAR(255) NOT NULL,
                       password VARCHAR(255) NOT NULL,
                       user_name VARCHAR(100) UNIQUE NOT NULL,
                       imagen_path varchar(255) DEFAULT NULL

);