DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `cuit` text DEFAULT NULL,
  `iva` text DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clientes` (`idcliente`, `nombre`, `apellido`, `email`, `cuit`,`iva`, `fechaCreacion`) VALUES
(1, 'Carlos', 'Argento', 'carlosA@gmail.com', '20-37432645-6','Consumidor final', current_timestamp()),
(2, 'Daiana', 'Romero', 'Dai34@gmail.com', '27-32568790-2', 'Responsable inscripto',current_timestamp()),
(3, 'Alberto', 'Centurion', 'REPARADOR', '23-27587104-6','Monotributista', current_timestamp());

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;