DROP TABLE IF EXISTS clientes;

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `dni` int DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clientes` (`idcliente`, `nombre`, `apellido`, `dni`, `telefono`, `direccion`, `correo`, `saldo`, `fechaCreacion`) VALUES
(1, 'Carlos', 'Argento', 20300300, 3454005000, 'Saavedra 13', 'carlosA@gmail.com', 355.00, current_timestamp()),
(2, 'Agustina', 'Perez', 30555000, 3454123456, 'Chabrillon 1550', 'agustina@yahoo.com', -150.00, current_timestamp()),
(3, 'Juan', 'Rodriguez', 42800101, 3454654321, 'Chajari 350', 'juan@hotmail.com', 0.00, current_timestamp());

ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;