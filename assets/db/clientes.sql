DROP TABLE IF EXISTS `clientes`;

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `clientes` (
  `idCliente` int(0) NOT NULL AUTO_INCREMENT,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `dni` int(0) DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;