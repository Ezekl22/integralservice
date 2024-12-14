DROP DATABASE IF EXISTS integralservice;

CREATE DATABASE integralservice;

USE integralservice;

-- tabla de usuarios


-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS usuarios;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `tipo` text NOT NULL,
  `mail` text NOT NULL,
  `contrasena` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `tipo`, `mail`, `contrasena`) VALUES

(1, 'Pedro1', 'Pintoss', 'Reparador', 'Pedro22@gmail.com', '123'),
(2, 'ADMINISTRADOR BASE', 'ADMIN', 'Administrador base', 'ADMINISTRADOR@gmail.com', '123'),
(3, 'Alberto', 'Centurion', 'Vendedor', 'Alberto22@gmail.com', '123');

ALTER TABLE `usuarios`
ADD PRIMARY KEY (`idusuario`);

ALTER TABLE `usuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- tabla de gestion de pantallas


-- DROP TABLE IF EXISTS gestionpantallas;

-- CREATE TABLE `gestionpantallas` (
--   `idgestionpantalla` int(11) NOT NULL,
--   `name` text NOT NULL,
--   `action` text NOT NULL,
--   `inuse` tinyint(2) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT INTO `gestionpantallas` (`idgestionpantalla`, `name`, `action`, `inuse`) VALUES
-- (1, 'usuarios', 'editar', false),
-- (2, 'clientes', 'editar', false),
-- (3, 'proveedores', 'editar', false),
-- (4, 'presupuestos', 'editar', false),
-- (5, 'pedidosCompra', 'editar', false),
-- (6, 'productos', 'editar', false),
-- (7, 'reparaciones', 'editar', false);

-- ALTER TABLE `gestionpantallas`
-- ADD PRIMARY KEY (`idgestionpantalla`);

-- ALTER TABLE `gestionpantallas`
-- MODIFY `idgestionpantalla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--tabla de clientes

-- DROP TABLE IF EXISTS clients;

DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `cuit` text DEFAULT NULL,
  `categoriafiscal` text DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clientes` (`idcliente`, `nombre`, `apellido`, `email`, `cuit`,`categoriafiscal`, `fechaCreacion`) VALUES
(1, 'Carlos', 'Argento', 'carlosA@gmail.com', '20-37432645-6','Consumidor final', current_timestamp()),
(2, 'Daiana', 'Romero', 'Dai34@gmail.com', '27-32568790-2', 'Responsable inscripto',current_timestamp()),
(3, 'Alberto', 'Centurion', 'REPARADOR', '23-27587104-6','Monotributista', current_timestamp());

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- tabla presupuestos

DROP TABLE IF EXISTS presupuestos;

CREATE TABLE `presupuestos` (
  `idpresupuesto` int(11) NOT NULL,
  `idclient` int(11) NOT NULL,
  `nrocomprobante` int(11) NOT NULL,
  `estado` text NOT NULL,
  `fecha` date NOT NULL,
  `puntoventa` int(11) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `presupuestos` (`idpresupuesto`, `idclient`,`nrocomprobante`, `estado`, `fecha`,`puntoventa`,`total`) VALUES
(1, 2, 'C-013456789', 'Presupuestado', '05-02-2023', '0001', 2000),
(2, 1, 'C-098735610', 'Pendiente presupuesto', '09-05-2023','0001', 3500),
(3, 3, 'C-312751963', 'Reparado', '08-06-2023', '0001', 6000);

ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`idpresupuesto`),
  ADD KEY `idcliente` (`idclient`);


ALTER TABLE `presupuestos`
  MODIFY `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`idclient`) REFERENCES `clients` (`idclient`) ON DELETE CASCADE ON UPDATE CASCADE;