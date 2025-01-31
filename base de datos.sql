CREATE DATABASE hitoprogramacion
USE hitoprogramacion 

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  edad INT NOT NULL,
  plan_base ENUM('Basico', 'Estandar', 'Premium') NOT NULL,
  duracion ENUM('Mensual', 'Anual') NOT NULL
);

INSERT INTO usuarios (nombre, apellido, email, edad, plan_base, duracion) VALUES
  ('Carlos', 'Gómez', 'carlos.gomez@example.com', 38, 'Estandar', 'Anual'),
  ('Laura', 'Díaz', 'laura.diaz@example.com', 27, 'Premium', 'Mensual'),
  ('Miguel', 'Herrera', 'miguel.herrera@example.com', 45, 'Basico', 'Anual'),
  ('Sofía', 'Ramírez', 'sofia.ramirez@example.com', 33, 'Estandar', 'Mensual'),
  ('Javier', 'Morales', 'javier.morales@example.com', 29, 'Premium', 'Anual'),
  ('Marta', 'Castillo', 'marta.castillo@example.com', 41, 'Basico', 'Anual'),
  ('Alejandro', 'Flores', 'alejandro.flores@example.com', 26, 'Estandar', 'Mensual'),
  ('Gabriela', 'Rojas', 'gabriela.rojas@example.com', 35, 'Premium', 'Anual'),
  ('Daniel', 'Vargas', 'daniel.vargas@example.com', 30, 'Basico', 'Anual'),
  ('Valeria', 'Gutiérrez', 'valeria.gutierrez@example.com', 24, 'Estandar', 'Mensual');