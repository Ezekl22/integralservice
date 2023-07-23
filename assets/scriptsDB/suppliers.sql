DROP TABLE IF EXISTS proveedores;

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `categoria_fiscal` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` int DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `fechaCreacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `proveedores` (`idproveedor`, `nombre`, `categoria_fiscal`, `direccion`, `telefono`, `correo`, `saldo`, `fechaCreacion`) VALUES
(1, 'Carlos', 'monotributista', 'Urquiza 99', 3451234567, 'carlosA@gmail.com', 555, current_timestamp()),
(2, 'Mariana', 'Responsable Inscripto', 'Pellegrini 99', 3457654321, 'mariana@gmail.com', 555, current_timestamp()),
(3, 'Carlos', 'monotributista', 'Urquiza 99', 3451234567, 'carlosA@gmail.com', 555, current_timestamp()),

ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;