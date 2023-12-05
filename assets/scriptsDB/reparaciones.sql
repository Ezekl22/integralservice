DROP TABLE IF EXISTS reparaciones;
CREATE TABLE `reparaciones` (
  `idreparacion` int(11) NOT NULL,
  `idpresupuesto` int(11) NOT NULL,
  `modelo` text NOT NULL,
  `marca` text NOT NULL,
  `numeroserie` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- INSERT INTO `presupuestos` (`idpresupuesto`, `idcliente`,`nrocomprobante`, `tipo`, `estado`, `fecha`,`puntoventa`,`total`) VALUES
-- (1, 2, 'C-013456789', 'venta', 'Presupuestado', '05-02-2023', '0001', 140000),
-- (2, 1, 'C-098735610', 'venta', 'Pendiente presupuesto', '09-05-2023','0001', 100000),
-- (3, 1, 'C-312751963', 'reparacion', 'Reparado', '08-06-2023', '0001', 50000);
ALTER TABLE `reparaciones`
  ADD PRIMARY KEY (`idreparacion`),
  ADD KEY `idpresupuesto` (`idpresupuesto`);

ALTER TABLE `reparaciones`
  ADD CONSTRAINT `reparaciones_ibfk_1` FOREIGN KEY (`idpresupuesto`) REFERENCES `presupuestos` (`idpresupuesto`) ON DELETE CASCADE ON UPDATE CASCADE;
-- ALTER TABLE `presupuestos`
--   MODIFY `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;
-- ALTER TABLE `reparaciones`
--   ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE;