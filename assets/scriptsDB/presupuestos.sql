
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
(1, 2, 'C-013456789', 'Presupuestado', '05-02-2023', '0001', 140000),
(2, 1, 'C-098735610', 'Pendiente presupuesto', '09-05-2023','0001', 100000),
(3, 3, 'C-312751963', 'Reparado', '08-06-2023', '0001', 50000);

ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`idpresupuesto`),
  ADD UNIQUE KEY `idcliente` (`idclient`);


ALTER TABLE `presupuestos`
  MODIFY `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`idclient`) REFERENCES `clients` (`idclient`) ON DELETE CASCADE ON UPDATE CASCADE;
