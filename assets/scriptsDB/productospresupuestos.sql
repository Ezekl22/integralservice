DROP TABLE IF EXISTS productospresupuestos;

CREATE TABLE `productospresupuestos` (
  `idpresupuestoproducto` int(11) NOT NULL,
  `idpresupuesto` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `preciounit` double NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `productospresupuestos` (`idpresupuestoproducto`, `idpresupuesto`, `idproducto`, `preciounit`, `cantidad`) VALUES
(1, 2, 1, 70000, 2),
(2, 1, 2, 100000, 1),
(3, 1, 1, 70000, 2),
(4, 3, 3, 35000, 1);

ALTER TABLE `productospresupuestos`
  ADD PRIMARY KEY (`idpresupuestoproducto`),
  ADD KEY `idpresupuesto` (`idpresupuesto`,`idproducto`),
  ADD KEY `idproducto` (`idproducto`);

ALTER TABLE `productospresupuestos`
  MODIFY `idpresupuestoproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `productospresupuestos`
  ADD CONSTRAINT `productospresupuestos_ibfk_1` FOREIGN KEY (`idpresupuesto`) REFERENCES `presupuestos` (`idpresupuesto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productospresupuestos_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;