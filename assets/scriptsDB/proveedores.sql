drop table if exists proveedores;
CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `categoria_fiscal` text NOT NULL,
  `direccion` text NOT NULL,
  `telefono` int NOT NULL,
  `correo` text NOT NULL,
  `saldo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `proveedores` (`idproveedor`, `nombre`, `categoria_fiscal`, `direccion`, `telefono`, `correo`, `saldo`) VALUES
(1, 'Pepe', 'Monotributista', 'Irigoyen 1500', '3454021000', 'pepe@gmail.com', '500'),
(2, 'Pepa', 'Responsable Inscripto', 'Urquiza 350', '3454085050', 'pepa@yahoo.com', '-340'),
(3, 'Juan', 'Monotributista', 'Urdinarrain 1100', '3454200123', 'juan@hotmail.com', '10');

ALTER TABLE `proveedores`
ADD PRIMARY KEY (`idproveedor`);

ALTER TABLE `proveedores`
MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;