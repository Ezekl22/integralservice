DROP TABLE IF EXISTS `clients`;

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `clients` (
  `idCliente` int(0) NOT NULL AUTO_INCREMENT,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `dni` int DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

INSERT INTO `clients` (`nombre`, `apellido`, `dni`, `telefono`, `direccion`, `correo`, `saldo`) VALUES
('pepe', 'hernandez', 20000000, 3454567891, 'Urquiza 80', 'pepe@gmail.com', 200);