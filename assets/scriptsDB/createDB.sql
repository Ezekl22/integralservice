DROP DATABASE IF EXISTS integralservice;

CREATE DATABASE integralservice;

USE integralservice;

-- tabla de usuarios

-- DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lastname` text NOT NULL,
  `type` text NOT NULL,
  `mail` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `name`, `lastname`, `type`, `mail`, `password`) VALUES
(1, 'Pedro1', 'Pintoss', 'Administrador', 'Pedro22@gmail.com', '123'),
(2, 'ADMINISTRADOR', 'ADMIN', 'ADMINISTRADOR', 'ADMINISTRADOR@gmail.com', '123'),
(3, 'Alberto', 'Centurion', 'REPARADOR', 'Alberto22@gmail.com', '123');

ALTER TABLE `users`
ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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

CREATE TABLE `clients` (
  `idclient` int(11) NOT NULL,
  `name` text NOT NULL,
  `lastname` text NOT NULL,
  `dni` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text NOT NULL,
  `mail` text NOT NULL,
  `balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `clients` (`idclient`, `name`, `lastname`, `dni`, `phone`, `address`, `mail`, `balance`) VALUES
(1, 'oscar', 'rodriguez', 29482657, 3454652318, 'salta 1200', 'rodriguez@gmail.com',500),
(2, 'javier', 'morinico', 324389230, 3454624830, 'eva peron 320', 'morinico32@gmail.com',1000),
(3, 'belen', 'uriarte', 20698532, 3454987210, 'entre rios 2000', 'belenur@gmail.com',0);

ALTER TABLE `clients`
ADD PRIMARY KEY (`idclient`);

ALTER TABLE `clients`
MODIFY `idclient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD UNIQUE KEY `idcliente` (`idclient`);


ALTER TABLE `presupuestos`
  MODIFY `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`idclient`) REFERENCES `clients` (`idclient`) ON DELETE CASCADE ON UPDATE CASCADE;